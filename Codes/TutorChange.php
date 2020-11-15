<?php
	
	if(isset($_POST['tutoridfinal']))
	{
		include('Connection.php');
		
		if(mysqli_connect_error())
		{
			die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
		}
		else
		{
			$student = 'SELECT * FROM `students` WHERE `Student Id` = '.$_POST['studentidfinal'];
			$studentinfo = mysqli_fetch_array(mysqli_query($conn, $student));
			
			$tutor = 'SELECT * FROM `tutors` WHERE `Lect ID` = '.$_POST['tutoridfinal'];
			$tutorinfo = mysqli_fetch_array(mysqli_query($conn, $tutor));
			
			$changetutor = 'UPDATE students set `Tutor Id` = '.$_POST['tutoridfinal'].' WHERE `Student Id` = '.$_POST['studentidfinal'];
			$change = mysqli_query($conn, $changetutor);
			
			if($change)
			{
			   echo '<h3>Tutor Changed Successfully!</h3>';
			   echo $studentinfo['First Name'].' is now under the tutoring of '.$tutorinfo['Name'];
			}
			else
			{
			   echo '<h3>Could not change tutor!</h3><br /><h5>Error description:</h5> '.mysqli_error($conn);
			}
		}
	}
	
?>