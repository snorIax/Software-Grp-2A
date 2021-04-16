<?php

	include_once('Connection.php');

	$schools = mysqli_query($conn,'SELECT DISTINCT `School` FROM `academic plan codes`') or die('schools error');
	
	while($school = mysqli_fetch_array($schools, MYSQLI_ASSOC))
	{
		$students = mysqli_query($conn,'SELECT * FROM `temp` INNER JOIN `academic plan codes` ON `temp`.`Academic Plan Code` = `academic plan codes`.`Code` WHERE `academic plan codes`.School LIKE "'.addslashes($school['School']).'"') or die('students error');
		
		$tutors = mysqli_query($conn,'SELECT * FROM `tutors` WHERE School LIKE "'.$school['School'].'"') or die('tutors error 1');
		
		$numoftutors = mysqli_num_rows($tutors);
		$numofstudents = mysqli_num_rows($students);
		$studentspertutor = floor($numofstudents/$numoftutors);
		
		while($tutor = mysqli_fetch_array($tutors, MYSQLI_ASSOC))
		{
			for($a = 0; $a < $studentspertutor; $a++)
			{
				$student = mysqli_fetch_array($students, MYSQLI_ASSOC);
				if (empty($student['Year of Entry (UG)']))
				{
					$student['Year of Entry (UG)'] = "0";
				}
				$studentstotutor = 'INSERT into students(`Student ID`,`Full Name`,`First Name`,`Last Name`,`Nationality`,`Gender`,`Academic Plan Code`,`Intake`,`Year of Entry (UG)`,`Current Year`,`Fnd 2-sem or 3-sem?`,`New`,`Level`,`Email Address`,`Registration Date`,`Registered`,`Remarks`,`Remarks 2`,`Tutor Id`) values('.$student['Student Id'].',"'.addslashes($student['Full Name']).'","'.addslashes($student['First Name']).'","'.addslashes($student['Last Name']).'","'.$student['Nationality'].'","'.$student['Gender'].'","'.$student['Academic Plan Code'].'","'.$student['Intake'].'",'.$student['Year of Entry (UG)'].','.$student['Year of Entry (UG)'].',"'.$student['Fnd 2-sem or 3-sem?'].'","Yes","'.$student['Level'].'","'.$student['Email Address'].'","'.$student['Registration Date'].'","'.$student['Registered'].'","","'.$student['Remarks 2'].'",'.$tutor['Lect ID'].')';
				mysqli_query($conn, $studentstotutor) or die('students to tutor error 1   '.mysqli_error($conn).'   '.$studentstotutor);
			}
		}
		
		$tutors = mysqli_query($conn,'SELECT `Lect ID` FROM `tutors` WHERE School LIKE "'.$school['School'].'"') or die('tutors error 2');
		$tutor = mysqli_fetch_array($tutors, MYSQLI_ASSOC);
		
		while($student = mysqli_fetch_array($students, MYSQLI_ASSOC))
		{
			if (empty($student['Year of Entry (UG)']))
			{
				$student['Year of Entry (UG)'] = "0";
			}
			$studentstotutor = 'INSERT into students(`Student ID`,`Full Name`,`First Name`,`Last Name`,`Nationality`,`Gender`,`Academic Plan Code`,`Intake`,`Year of Entry (UG)`,`Current Year`,`Fnd 2-sem or 3-sem?`,`New`,`Level`,`Email Address`,`Registration Date`,`Registered`,`Remarks`,`Remarks 2`,`Tutor Id`) values('.$student['Student Id'].',"'.addslashes($student['Full Name']).'","'.addslashes($student['First Name']).'","'.addslashes($student['Last Name']).'","'.$student['Nationality'].'","'.$student['Gender'].'","'.$student['Academic Plan Code'].'","'.$student['Intake'].'",'.$student['Year of Entry (UG)'].','.$student['Year of Entry (UG)'].',"'.$student['Fnd 2-sem or 3-sem?'].'","Yes","'.$student['Level'].'","'.$student['Email Address'].'","'.$student['Registration Date'].'","'.$student['Registered'].'","","'.$student['Remarks 2'].'",'.$tutor['Lect ID'].')';
			mysqli_query($conn, $studentstotutor) or die('students to tutor error 2   '.mysqli_error($conn).'   '.$studentstotutor);
		}
	}
	
?>