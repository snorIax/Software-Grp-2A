<?php
	session_start();

	include('Connection.php');

	// get required data
	$search = $_REQUEST["search"];
	$filter = $_REQUEST["filter"];
	$userid = $_SESSION['userid'];
	$alltuteeslist = $_SESSION['all'];
	
	// Query to look for the current school association
	$schoolquery = mysqli_query($conn,'SELECT School FROM `tutors` WHERE `Lect ID` = '.$userid) or die('school error');
	$school = mysqli_fetch_array($schoolquery, MYSQLI_ASSOC);
	
	//check if empty, then display all
	if($search == "")
	{
		if($filter == -1)
		{
			// Query to look for the tutees of their specific tutees or all tutees under the same school
			$theirtutees = mysqli_query($conn,'SELECT * FROM `students` WHERE `Tutor Id` = '.$userid) or die('their tutees error');
			$alltutees = mysqli_query($conn,'SELECT * FROM `students` INNER JOIN `academic plan codes` ON `students`.`Academic Plan Code` = `academic plan codes`.`Code` INNER JOIN `tutors` ON `students`.`Tutor Id` = `tutors`.`Lect ID` WHERE `academic plan codes`.School LIKE "'.$school['School'].'"') or die('all tutees error');
		}
		else
		{
			// Query to look for the tutees of their specific tutees or all tutees under the same school
			$theirtutees = mysqli_query($conn,'SELECT * FROM `students` WHERE `Tutor Id` = '.$userid.' AND `Current Year` = '.$filter) or die('their tutees error');
			$alltutees = mysqli_query($conn,'SELECT * FROM `students` INNER JOIN `academic plan codes` ON `students`.`Academic Plan Code` = `academic plan codes`.`Code` INNER JOIN `tutors` ON `students`.`Tutor Id` = `tutors`.`Lect ID` WHERE `academic plan codes`.School LIKE "'.$school['School'].'" AND `Current Year` = '.$filter) or die('all tutees error');
		}
	}
	else
	{
		if($filter == -1)
		{
			// Query to look for the tutees of their specific tutees or all tutees under the same school
			$theirtutees = mysqli_query($conn,'SELECT * FROM `students` WHERE `Tutor Id` = '.$userid.' AND (`Student Id` LIKE "%'.$search.'%" OR `First Name` LIKE "%'.$search.'%" OR `Last Name` LIKE "%'.$search.'%" OR `Full Name` LIKE "%'.$search.'%")') or die('their tutees error');
			$alltutees = mysqli_query($conn,'SELECT * FROM `students` INNER JOIN `academic plan codes` ON `students`.`Academic Plan Code` = `academic plan codes`.`Code` INNER JOIN `tutors` ON `students`.`Tutor Id` = `tutors`.`Lect ID` WHERE `academic plan codes`.School LIKE "'.$school['School'].'" AND (`Student Id` LIKE "%'.$search.'%" OR `First Name` LIKE "%'.$search.'%" OR `Last Name` LIKE "%'.$search.'%" OR `Full Name` LIKE "%'.$search.'%")') or die('all tutees error');
		}
		else
		{
			// Query to look for the tutees of their specific tutees or all tutees under the same school
			$theirtutees = mysqli_query($conn,'SELECT * FROM `students` WHERE `Tutor Id` = '.$userid.' AND (`Student Id` LIKE "%'.$search.'%" OR `First Name` LIKE "%'.$search.'%" OR `Last Name` LIKE "%'.$search.'%" OR `Full Name` LIKE "%'.$search.'%") AND `Current Year` = '.$filter) or die('their tutees error');
			$alltutees = mysqli_query($conn,'SELECT * FROM `students` INNER JOIN `academic plan codes` ON `students`.`Academic Plan Code` = `academic plan codes`.`Code` INNER JOIN `tutors` ON `students`.`Tutor Id` = `tutors`.`Lect ID` WHERE `academic plan codes`.School LIKE "'.$school['School'].'" AND (`Student Id` LIKE "%'.$search.'%" OR `First Name` LIKE "%'.$search.'%" OR `Last Name` LIKE "%'.$search.'%" OR `Full Name` LIKE "%'.$search.'%") AND `Current Year` = '.$filter) or die('all tutees error');
		}
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
		$display = 'There were no search results!';
	}
	else 
	{
		$display = '<table class="fl-table">
						<thead>
							<tr>
								<th>Student ID</td>
								<th>Student Full Name</td>';
		
		
		if($alltuteeslist)
		{
			$display .= '<th>Tutor</th><th>Change Tutor</th></tr>';
		}
		
		$display .= '</tr>
					</thead>
					<tbody>';
		
		while($rows = mysqli_fetch_array($displaylist,MYSQLI_ASSOC))
		{
			// main information
			$display .= '<tr>
							<td><a onclick="gototuteepage('.$rows['Student Id'].')" style="cursor: pointer">'.$rows['Student Id'].'</a></td>
							<td>'.$rows['Full Name'].'</td>';
			
			// if is list of all tutees, display tutors and changing option
			if($alltuteeslist)
			{
				$display .= '<td>'.$rows['Name'].'</td>
							<td>
								<form id="'.$rows['Student Id'].'" action="#changetutor" method="POST">
									<input type="hidden" name="studentid" value="'.$rows['Student Id'].'"/>
									<input type="hidden" name="fname" value="'.$rows['Full Name'].'"/>
									<input type="hidden" name="tutorid" value="'.$rows['Tutor Id'].'"/>
									
									<input class="changeTutor" type="submit" value="Change Tutor" />
								</form>
							</td>';
			}
		
			$display .= '</tr>';
		}
		
		$display .= '</tbody>
					</table>';
	}
	
	// Return output to main page
	echo $display;

?>