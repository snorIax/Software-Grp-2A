
<?php
session_start();
include_once('Connection.php');
if(isset($_POST['submit']))
{
    $id = $_POST['studentid'];
    $result = mysqli_query($conn, "SELECT * FROM students WHERE `Student Id` =".$id) or die(mysqli_error());
	
	if(mysqli_num_rows($result)) 
	{
		$row = mysqli_fetch_array($result);
		$fetch_student_id = $row['Student Id'];
		$email_id = $row['Email Address'];
		$password = $row['Password'];
	
		$to = $email_id;
		$subject = "Password";
		$txt = "Your password is : $password.";
		$headers = "From: tutortuteesystem@gmail.com" . "\r\n";
		if(mail($to,$subject,$txt,$headers))
		{
			echo '<script>window.confirm("The password has been sent to the registered email!");</script>';
		}
		else
		{
			echo "<script>window.alert('Error: Message cannot be sent');<script>";
		}
	}
	else
	{
		echo '<script>window.alert("Error: Invalid Student ID!");</script>';
	}
}
?>

<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
		<title>Login Page</title>
		<link rel="stylesheet" href="login.css">
	</head>

	<body>

		<section>

			<div class="container">
				<div class="login-form">
					<h1>Forgot Password</h1>
					<p style="color:white;">Enter ID and the password will be sent to the registered email</p>
					<form method="post" action="" id="forgotPassword">
						<input type="text" name="studentid" id="studentid" placeholder="ID" required value="">
						<input type="submit" name="submit" value="Continue">
					</form>
					<a href="Loginpage.php">Back to Login</a>
				</div>
				<img src="unmclogo.png" alt="UNMC logo">
			</div>

		</section>
		
			</body>

</html>