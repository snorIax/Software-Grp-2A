<?php

	if(isset($_POST['loginsubmit']))
	{

		include_once('Connection.php');
		
		if(mysqli_connect_error())
		{
			die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
		}
		else
		{
			$userid = $_POST['id'];
			$userpassword = $_POST['password'];
			
			$administratorstable = "SELECT * FROM `administrators` WHERE `Admin ID` = ".$userid;
			$seniortutorstable = "SELECT * FROM `senior tutors` WHERE `Lect ID` = ".$userid;
			$tutorstable = "SELECT * FROM `tutors` WHERE `Lect ID` = ".$userid;
			
			$isadmin = mysqli_query($conn, $administratorstable) or die("Administrator error");
			$isseniortutor = mysqli_query($conn, $seniortutorstable) or die("Senior tutor error");
			$istutor = mysqli_query($conn, $tutorstable) or die("Tutor error");
			
			//check if administrator staff
			if (mysqli_num_rows($isadmin))
			{
				$admindetail = mysqli_fetch_array($isadmin, MYSQLI_ASSOC);
				if($userpassword == $admindetail['Password'])
				{
					$st = 2;
				}
				else
				{
					echo '<script>window.alert("Error: Password does not match!");</script>';
				}
			}
			//check if senior tutor
			elseif (mysqli_num_rows($isseniortutor))
			{
				$tutordetail = mysqli_fetch_array($istutor, MYSQLI_ASSOC);
				if($userpassword == $tutordetail['Password'])
				{
					$st = 1;
				}
				else
				{
					echo '<script>window.alert("Error: Password does not match!");</script>';
				}
			}
			//check if normal tutor
			elseif (mysqli_num_rows($istutor))
			{
				$tutordetail = mysqli_fetch_array($istutor, MYSQLI_ASSOC);
				if($userpassword == $tutordetail['Password'])
				{
					$st = 0;
				}
				else
				{
					echo '<script>window.alert("Error: Password does not match!");</script>';
				}
			}
			else
			{
				echo '<script>window.alert("Error: ID does not exist!");</script>';
			}
		}
	}

?>