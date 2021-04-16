<?php
	session_start();

	include_once('Connection.php');
	
	error_reporting(0);
	
	// If haven't login, then change to login page
	if((!(isset($_SESSION['userid']))) or ($_SESSION['category'] != "Tutor"))
	{
		header("Location:Loginpage.php");
	}
	
	$userid = $_SESSION['userid'];
	$tuteeid = $_POST['tuteeid'];
	
	$new = $_POST['new'];
	$edit = $_POST['edit'];
	$delete = $_POST['delete'];
	
	$remarks = $_POST['remarks'];
	$date = $_POST['timestamp'];
	
	if(isset($remarks) and isset($new))
	{
		$remarksquery = mysqli_query($conn, 'INSERT INTO `remarks` (`Student Id`, `Date`, `Remarks`, `Lect Id`) VALUES ('.$tuteeid.', current_timestamp(), "'.$remarks.'", '.$userid.')') or die('Add Remarks error');
	}
	else if(isset($remarks) and isset($edit))
	{
		$remarksquery = mysqli_query($conn, 'UPDATE `remarks` SET `Remarks` = "'.$remarks.'" WHERE Date = "'.$date.'" AND `Student Id` = '.$tuteeid) or die('Edit Remarks error');
	}
	else if(isset($remarks) and isset($delete))
	{
		$remarksquery = mysqli_query($conn, 'DELETE FROM `remarks` WHERE `Student Id` = '.$tuteeid.' AND Date = "'.$date.'"') or die('Edit Remarks error');
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="default.css">
		
		<title>
			New Remarks
		</title>
		
	</head>
	
	<body>
	<!-- Start Menu -->
	<div class="nav-btn">Menu</div>
	<div class="container">
		<div class="sidebar">

			<nav>
				<a href="#">NottsTutor <span>System</span></a>
				<ul>
					<li><a href="UserInformationTutors.php?LectID=<?php echo $userid ?>">Profile</a></li>
					<li><a href="Search.php">Search</a></li>
					<li><a href="Loginpage.php">Log Out</a></li>
				</ul>

			</nav>
		</div>

	<!-- End Menu -->
	<center><div class="main-content">	
		<form id="remarksform" action="" method="POST">
			<input type="hidden" name="tuteeid" value="<?php echo $tuteeid; ?>" />
			<input type="hidden" name="timestamp" value="<?php echo $date; ?>" />
		<div class="panel-wrapper">
			<div class="panel-head">
			<span><b>Remarks:</b></span>
			<br />
			<textarea id="remarks" name="remarks" rows="10" cols="100"><?php if($new == NULL){echo $remarks;} ?></textarea>
			<br />
			<?php
				if(isset($new))
				{
					echo '<input type="hidden" name="new" value="1" />';
					echo '<input type="button" value="Back" onclick="goback()" />';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '<input type="button" value="Add remarks" onclick="toadd()" />';
				}
				else
				{
					echo '<input type="hidden" id="editordelete" name="" value="1" />';
					echo '<input type="button" value="Back" onclick="goback()" />';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '<input type="button" value="Edit remarks" onclick="toedit()" />';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '<input type="button" value="Delete remarks" onclick="todelete()" />';
				}
			?>
		</form>
		
		<!-- form to pass details back to tutee page-->
		<form id="alldata" action="Tuteepage.php" method="POST">
			<input type="hidden" id="tuteeid" name="tuteeid" value="<?php echo $tuteeid; ?>" />
		</form>
		</div>
		<!--
		<form id="delete" action="" method="POST">
		</form>
		-->
		
		<?php
			if(isset($remarks) and ((isset($new) or isset($edit)) or isset($delete)))
			{
				echo '<script>document.getElementById("alldata").submit();</script>';
			}
		?>
		
<script>
function toadd()
{
	if (!(document.getElementById("remarks").value == ""))
	{
		document.getElementById("remarksform").submit();
	}
	else
	{
		window.alert("Error: Remarks cannot be empty");
	}
}
</script>
		
<script>
function toedit()
{
	if (!(document.getElementById("remarks").value == ""))
	{
		document.getElementById("editordelete").name = "edit";
		document.getElementById("remarksform").submit();
	}
	else
	{
		window.alert("Error: Remarks cannot be empty");
	}
}
</script>

<script>
function todelete()
{
	document.getElementById("editordelete").name = "delete";
	document.getElementById("remarksform").submit();
}
</script>

<script>
function goback()
{
	document.getElementById("alldata").submit();
}
</script>
			</div>
		</div>
	</div></center>
	</body>
	
</html>