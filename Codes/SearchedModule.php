<?php

	include('Connection.php');

	// get required data
	$search = $_REQUEST["search"];
	
	//check if empty, then display all
	if($search == "")
	{
		// Query for all available modules
		$searchmodule = mysqli_query($conn,'SELECT * FROM `academic plan codes`') or die('all modules error');
	}
	else
	{
		// Query to look for searched modules
		$searchmodule = mysqli_query($conn,'SELECT * FROM `academic plan codes` WHERE `Code` LIKE "%'.$search.'%" OR `Academic Plan` LIKE "%'.$search.'%"') or die('search module error');
	}
	
	$displaylist = $searchmodule;
	
	// check number of result from query
	$count = mysqli_num_rows($displaylist);
	
	if($count == 0) 
	{
		$display = 'There were no search results!';
	}
	else 
	{
		$display = '<table class="fl-table">
						<thead>
							<tr>
								<th><strong>Code</td>
								<th><strong>Academic Plan</td>
								<th><strong>School</td>';
		
		$display .= '</tr>
					</thead>
					<tbody>';
		
		while($rows = mysqli_fetch_array($displaylist,MYSQLI_ASSOC))
		{
			// main information
			$display .= '<tr>
							<td><a onclick="gotomoduleeditpage(\''.$rows['Code'].'\')" style="cursor: pointer">'.$rows['Code'].'</a></td>
							<td>'.$rows['Academic Plan'].'</td>
							<td>'.$rows['School'].'</td>';
		
			$display .= '</tr>';
		}
		
		$display .= '</tbody>
					</table>';
	}
	
	// Return output to main page
	echo $display;

?>