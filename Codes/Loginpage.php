<?php

	$st = -1;
	include('Login.php');

?>

<!doctype html>

<html>
	<head>
		<meta charset="utf-8">
		<title>Login Page</title>
		<link rel="stylesheet" href="style.css">
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

		<form method="post" action="Tutorpage.php" id="logindata">
			<input type="hidden" name="LectID" value="<?php echo $userid; ?>" />
			<input type="hidden" id="st" name="st" value="" />
			<input type="hidden" name="all" value="0" />
		</form>

		<form method="post" action="Importpage.php" id="importdata">
		</form>

		<form method="post" action="StudentView.php" id="studentlogin">
			<input type="hidden" name="studentID" value="<?php echo $userid; ?>" />
		</form>


<?php

	if($st != -1)
	{
		if($st == 2)
		{
			echo '<script>document.getElementById("importdata").submit();</script>';
		}
		elseif ($st==3) {
				echo '<script>document.getElementById("studentlogin").submit();</script>';
		}
		else
		{
			echo '<script>document.getElementById("st").value = '.$st.';</script>';
			echo '<script>document.getElementById("logindata").submit();</script>';
		}
	}

?>

	</body>

</html>
