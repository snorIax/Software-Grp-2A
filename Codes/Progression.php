<?php
    if(isset($_POST['progressingyear']))
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
			
			$year = $_POST['progressingyear'];
			
            
            //$progress = 'SELECT * FROM `students` WHERE `Current Year` = '.$_POST['progress'];
			//$progressinfo = mysqli_fetch_array(mysqli_query($conn, $progress));
			
			if($year == 1)
			{
				$changeyear = 'UPDATE students set `Current Year` = '.$year.', `Fnd 2-sem or 3-sem?` = "", `New` = "No", `Level` = "Undergraduate" WHERE `Student Id` = '.$_POST['studentidfinal'];
			}
			else if (($year >= 2) and ($year <= 4))
			{
				$changeyear = 'UPDATE students set `Current Year` = '.$year.', `New` = "No" WHERE `Student Id` = '.$_POST['studentidfinal'];
			}
			else if($year == 6)
			{
				$changeyear = 'UPDATE students set `Current Year` = '.$year.', `New` = "No", `Level` = "Postgraduate Taught" WHERE `Student Id` = '.$_POST['studentidfinal'];
			}
			else if($year == 7)
			{
				$changeyear = 'UPDATE students set `Current Year` = '.$year.', `New` = "No", `Level` = "Postgraduate Research" WHERE `Student Id` = '.$_POST['studentidfinal'];
			}
			
			$change = mysqli_query($conn, $changeyear);
			
			if($change)
			{
			   echo '<h3>Current Year Changed Successfully!</h3>';
			   if(($year >= 1) and ($year <= 4))
				{
					echo $studentinfo['First Name'].' is now in Undergraduate year '.$year;
				}
				else if($year == 6)
				{
					echo $studentinfo['First Name'].' is now in Postgraduate Taught';
				}
				else if($year == 7)
				{
					echo $studentinfo['First Name'].' is now in Postgraduate Research';
				}
			   //echo $studentinfo['First Name'].' is now in year '.$progressinfo['Current Year'];
			}
			else
			{
			   echo '<h3>Could not change year!</h3><br /><h5>Error description:</h5> '.mysqli_error($conn);
			}
		}
	}
?>