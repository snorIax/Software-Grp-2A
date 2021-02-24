<?php
	include('Connection.php');
	include('Import.php');
	
	// Holds the admin
	$userid = $_POST['AdminID'];
	
	// If haven't login, then change to login page
	if(!(isset($userid)))
	{
		header("Location:Loginpage.php");
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" href="default.css">
		<title>
			File Submission
		</title>
	</head>
<!-- Start Menu -->
	<div class="nav-btn">Menu</div>
	<div class="container">
		<div class="sidebar">
		
			<nav>
				<a href="#">Tutor <span>WebApp</span></a>
				<ul>
					<li><a href="loginpage.php">Log Out</a></li>
				</ul>
				
			</nav>
		</div>
		
	<!-- End Menu -->	
	<div class="main-content">
			<h3><b>File Submission: </b></h3>
			<br>	
			<!-- Start Panel -->
			<div class="panel-wrapper">
				<div class="panel-head">
			<!-- Start Table -->
	
			<form enctype="multipart/form-data" method="post" action="" id="importfile">
			<table class="fl-table">
				<thead>
					<tr >
						<th colspan="2"><strong>Import CSV file</strong></th>
					</tr>
					<tr>
						<td	>CSV File:</td><td><input style="margin-right: 10%;" type="file" name="file" id="file"></td>
					</tr>
					<tr >
						<td colspan="2"><input type="submit" name="submitfile"></td>
					</tr>
				</thead>
			</table>
		</form>

				<!-- End Table -->
				</div>
			</div>
			<!-- End Panel -->
			</div>
</html>



  