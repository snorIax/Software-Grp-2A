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
	$edit = $_POST['edit'];
	$delete = $_POST['delete'];
	
	$oldcode = $_POST['modulecode'];
	
	$code = $_POST['code'];
	$acadplan = $_POST['acadplan'];
	$school = $_POST['school'];
	
	$codebeforeedit = $_POST['codebeforeedit'];
	
	if(!($oldcode == null))
	{
		$oldmodule = mysqli_query($conn, 'SELECT * FROM `academic plan codes` WHERE Code LIKE "'.$oldcode.'"') or die('Get a Module error');
		$oldmoduledata = mysqli_fetch_array($oldmodule, MYSQLI_ASSOC);
	}
	
	if(isset($add))
	{
		$modulequery = mysqli_query($conn, 'INSERT INTO `academic plan codes` (`Code`, `Academic Plan`, `School`) VALUES ("'.$code.'", "'.$acadplan.'", "'.$school.'")') or die('Add Modules error');
	}
	else if(isset($edit))
	{
		$modulequery = mysqli_query($conn, 'UPDATE `academic plan codes` SET `Code` = "'.$code.'", `Academic Plan` = "'.$acadplan.'", `School` = "'.$school.'" WHERE Code LIKE "'.$codebeforeedit.'"') or die('Edit Modules error');
	}
	else if(isset($delete))
	{
		$modulequery = mysqli_query($conn, 'DELETE FROM `academic plan codes` WHERE `Code` LIKE "'.$codebeforeedit.'"') or die('Module may be in use by students');
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="default.css">
	
		<title>
			New Modules
		</title>
		
		<style>
		</style>
		
	</head>
	
	<body>
	<!-- Start Menu -->
	<div class="nav-btn">Menu</div>
	<div class="container">
		<div class="sidebar">
		
			<nav>
				<a href="#">NottsTutor <span></span></a>
				<ul>
					<li><a href="Importpage.php">Import File</a></li>
					<li><a href="Loginpage.php">Log Out</a></li>
				</ul>	
			</nav>
		</div>
	<!-- End Menu -->
	<div class="main-content">
		<div class="panel-wrapper">
			<div class="panel-head">	

		<form id="modulesform" action="" method="POST">
			
			<span><b>Code:</b></span>
			<input type="text" id="code" name="code" value="<?php echo $oldmoduledata['Code'] ?>" />
			<input type="hidden" name="codebeforeedit" value="<?php echo $oldmoduledata['Code'] ?>" />
			<br /><br />
			
			<span><b>Academic Plan:</b></span>
			<input type="text" id="acadplan" name="acadplan" value="<?php echo $oldmoduledata['Academic Plan'] ?>" />
			<br /><br />
			
			<span><b>School:</b></span>
			<input type="text" id="school" name="school" value="<?php echo $oldmoduledata['School'] ?>" />
			<br /><br />
			
			
			<input type="button" value="Back" onclick="goback()" />
		
			<?php
				if($oldcode == null)
				{
					echo '<input type="hidden" name="add" value="1" />';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '<input type="button" value="Add module" onclick="toadd()" />';
				}
				else
				{
					echo '<input type="hidden" id="editordelete" name="" value="1" />';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '<input type="button" value="Edit module" onclick="toedit()" />';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '<input type="button" value="Delete module" onclick="todelete()" />';
				}
			?>
		</form>
		
		<!-- form to go back to module page-->
		<form id="alldata" action="Newmodulepage.php" method="POST">
		</form>
	</div>
		<?php
			if(isset($add) or isset($edit) or isset($delete))
			{
				echo '<script>document.getElementById("alldata").submit();</script>';
			}
		?>
		
<script>
function goback()
{
	document.getElementById("alldata").submit();
}
</script>

<script>
function toadd()
{
	if (document.getElementById("code").value == "")
	{
		window.alert("Error: Code cannot be empty");
	}
	else if (document.getElementById("acadplan").value == "")
	{
		window.alert("Error: Academic plan cannot be empty");
	}
	else if (document.getElementById("school").value == "")
	{
		window.alert("Error: School cannot be empty");
	}
	else
	{
		document.getElementById("modulesform").submit();
	}
}
</script>

<script>
function toedit()
{
	if (document.getElementById("code").value == "")
	{
		window.alert("Error: Code cannot be empty");
	}
	else if (document.getElementById("acadplan").value == "")
	{
		window.alert("Error: Academic plan cannot be empty");
	}
	else if (document.getElementById("school").value == "")
	{
		window.alert("Error: School cannot be empty");
	}
	else
	{
		document.getElementById("editordelete").name = "edit";
		document.getElementById("modulesform").submit();
	}
}
</script>

<script>
function todelete()
{
	document.getElementById("editordelete").name = "delete";
	document.getElementById("modulesform").submit();
}
</script>
		</div>
	</div>
</div>
	</body>
	
</html>