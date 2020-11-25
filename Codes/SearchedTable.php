<?php

	include('Connection.php');

	// get required data
	$search = $_REQUEST["search"];
	$userid = $_REQUEST['LectID'];
	$isseniortutor = $_REQUEST['st'];
	$alltuteeslist = $_REQUEST['all'];
	
	// Query to look for the current school association
	$schoolquery = mysqli_query($conn,'SELECT School FROM `tutors` WHERE `Lect ID` = '.$userid) or die('school error');
	$school = mysqli_fetch_array($schoolquery, MYSQLI_ASSOC);
	
	//check if empty, then display all
	if($search == "")
	{
		// Query to look for the tutees of their specific tutees or all tutees under the same school
		$theirtutees = mysqli_query($conn,'SELECT * FROM `students` WHERE `Tutor Id` = '.$userid) or die('their tutees error');
		$alltutees = mysqli_query($conn,'SELECT * FROM `students` INNER JOIN `academic plan codes` ON `students`.`Academic Plan Code` = `academic plan codes`.`Code` WHERE School LIKE "'.$school['School'].'"') or die('all tutees error');
	}
	else
	{
		// Query to look for the tutees of their specific tutees or all tutees under the same school
		$theirtutees = mysqli_query($conn,'SELECT * FROM `students` WHERE `Tutor Id` = '.$userid.' AND (`Student Id` LIKE "%'.$search.'%" OR `First Name` LIKE "%'.$search.'%" OR `Last Name` LIKE "%'.$search.'%" OR `Full Name` LIKE "%'.$search.'%")') or die('their tutees error');
		$alltutees = mysqli_query($conn,'SELECT * FROM `students` INNER JOIN `academic plan codes` ON `students`.`Academic Plan Code` = `academic plan codes`.`Code` WHERE School LIKE "'.$school['School'].'" AND (`Student Id` LIKE "%'.$search.'%" OR `First Name` LIKE "%'.$search.'%" OR `Last Name` LIKE "%'.$search.'%" OR `Full Name` LIKE "%'.$search.'%")') or die('all tutees error');
	}
	
	if($alltuteeslist)
	{
		$displaylist = $alltutees;
	}
	else
	{
		$displaylist = $theirtutees;
	}
	
	// check number of result from query
	$count = mysqli_num_rows($displaylist);
	
	if($count == 0) 
	{
		$display = 'There were no search results!'; // This line doesnt work ?????
	}
	else 
	{
		$display = '<table border="1">
						<tr >
							<td align="center"><strong>ID</strong></td>
							<td align="center"><strong>Name</strong></td>';
		
		
		if($alltuteeslist)
		{
			$display .= '<td align="center"><strong>Tutor Id</strong></td></tr>';
		}
		
		$display .= '</tr>';
		
		while($rows = mysqli_fetch_array($displaylist,MYSQLI_ASSOC))
		{
			// main information
			$display .= '<tr>
							<td align="center"><a onclick="gototuteepage('.$rows['Student Id'].')" style="cursor: pointer">'.$rows['Student Id'].'</a></td>
							<td align="center">'.$rows['Full Name'].'</td>';
			
			// if is list of all tutees, display tutors and changing option
			if($alltuteeslist)
			{
				$display .= '<td align="center">'.$rows['Tutor Id'].'</td>
							<td align="center">
								<form id="'.$rows['Student Id'].'" action="#changetutor" method="POST">
									<input type="hidden" name="studentid" value="'.$rows['Student Id'].'"/>
									<input type="hidden" name="tutorid" value="'.$rows['Tutor Id'].'"/>
									
									<input type="hidden" name="LectID" value="'.$userid.'" />
									<input type="hidden" name="st" value="'.$isseniortutor.'" />
									<input type="hidden" name="all" value="'.$alltuteeslist.'" />
									
									<input type="submit" value="Change tutor" />
								</form>
							</td>';
			}
		
			$display .= '</tr>';
		}
		
		$display .= '</table>';
	}
	
	// Return output to main page
	echo $display;

?>