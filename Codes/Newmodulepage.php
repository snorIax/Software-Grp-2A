<?php
	session_start();

	include_once('Connection.php');
	
	error_reporting(0);
	
	// If haven't login, then change to login page
	if((!(isset($_SESSION['userid']))) or ($_SESSION['category'] != "Admin"))
	{
		header("Location:Loginpage.php");
	}
	
	$add = $_POST['add'];
	
	$code = $_POST['code'];
	$acadplan = $_POST['acadplan'];
	$school = $_POST['school'];
	
	if(isset($add))
	{
		$newmodulequery = mysqli_query($conn, 'INSERT INTO `academic plan codes` (`Code`, `Academic Plan`, `School`) VALUES ("'.$code.'", "'.$acadplan.'", "'.$school.'")') or die('Add Modules error');
	}

?>

<!DOCTYPE html>
<html>
	<head>
	
		<title>
			New Modules
		</title>
		
		<style>
		</style>
		
	</head>
	
	<body>

		<form id="modulesform" action="" method="POST">
			
			<span><b>Code:</b></span>
			<input type="text" name="code" />
			<br /><br />
			
			<span><b>Academic Plan:</b></span>
			<input type="text" name="acadplan" />
			<br /><br />
			
			<span><b>School:</b></span>
			<input type="text" name="school" />
			<br /><br />
			
			<input type="hidden" name="add" value="1" />
			<input type="submit" value="Add modules"/>
		</form>
		
		<!-- form to go back to module page-->
		<form id="alldata" action="Modulespage.php" method="POST">
		</form>
		
		<?php
			if(isset($add))
			{
				echo '<script>document.getElementById("alldata").submit();</script>';
			}
		?>
	
	</body>
	
</html>