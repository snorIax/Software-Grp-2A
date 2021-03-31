<?php

	session_start();
	$st = -1;
	
	include('Login.php');
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
					<h1>WebApp Login</h1>
					<form method="post" action="" id="login">
						<input type="text" name="id" id="id" placeholder="ID">
						<input type="password" name="password" id="password" placeholder="Password">
						<input type="submit" name="loginsubmit" value="Login">
					</form>
					<a href="#">Forget Password?</a>
				</div>
				<img src="unmclogo.png" alt="UNMC logo">
			</div>

		</section>

		<form method="post" action="Tutorpage.php" id="tutorlogin">
		</form>

		<form method="post" action="Importpage.php" id="importdata">
		</form>

		<form method="post" action="StudentView.php" id="studentlogin">
		</form>


<?php

	if($st != -1)
	{
		$_SESSION['userid'] = $_POST['id'];
		if($st == 2)
		{
			$_SESSION['category'] = "Admin";
			$_SESSION['whichschool'] = "all";
			echo '<script>document.getElementById("importdata").submit();</script>';
		}
		elseif ($st == 3) 
		{
			$_SESSION['category'] = "Student";
			echo '<script>document.getElementById("studentlogin").submit();</script>';
		}
		else
		{
			$_SESSION['category'] = "Tutor";
			$_SESSION['st'] = $st;
			$_SESSION['all'] = 0;
			echo '<script>document.getElementById("tutorlogin").submit();</script>';
		}
	}
	else
	{
		session_unset();
	}

?>

	</body>

</html>
