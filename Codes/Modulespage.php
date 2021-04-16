<?php
	session_start();
	
	include_once('Connection.php');
	
	// If haven't login, then change to login page
	if((!(isset($_SESSION['userid']))) or ($_SESSION['category'] != "Admin"))
	{
		header("Location:Loginpage.php");
	}
	
	$whichschool = $_SESSION['whichschool'];
	
	// Query to look for the current school association
	$schoolquery = mysqli_query($conn,'SELECT DISTINCT School FROM `academic plan codes`') or die('school error');
	$school = mysqli_fetch_array($schoolquery, MYSQLI_ASSOC);
	
	
	// Query to look for all modules
	$allmodulequery = 'SELECT * FROM `academic plan codes`';
	
	// Query to look for specific schools
	$specificmodulequery = 'SELECT * FROM `academic plan codes` WHERE school LIKE "'.$whichschool.'"';

?>

<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" href="default.css">
	
		<title>
			Modules
		</title>
		
		<style>
		.close 
		{
			position:absolute;
			transition:all 500ms;
			top:20px;
			right:30px;
			font-size:30px;
			font-weight:bold;
			text-decoration:none;
			color:black;
		}
		
		.overlay
		{
			position:fixed;
			top:0;
			bottom:0;
			left:0;
			right:0;
			background:rgba(0,50,75,0.7);
			transition:all 500ms;
			visibility:hidden;
			opacity:0;
		}

		.overlay:target
		{
			visibility:visible;
			opacity:1;
		}
		
		.popupchange
		{
			margin:225px auto;
			padding:15 30 30;
			background:white;
			border-radius:5px;
			width:22%;
			height:27%;
			position:relative;
			transition:all 5s ease-in-out;
		}
		
		.popupconfirm
		{
			margin:225px auto;
			padding:15 30 30;
			background:white;
			border-radius:5px;
			width:17%;
			height:25%;
			position:relative;
			transition:all 5s ease-in-out;
		}
		</style>
		
	</head>
	<!-- Start Menu -->
	<div class="nav-btn">Menu</div>
	<div class="container">
		<div class="sidebar">
		
			<nav>
				<a href="#">Tutor <span>WebApp</span></a>
				<ul>
					<li><a href="Importpage.php">Import File</a></li>
					<li><a href="Loginpage.php">Log Out</a></li>
				</ul>	
			</nav>
		</div>
	<!-- End Menu -->	
	<div class="main-content">
	
			<h3><b>Modules: </b></h3>
			<br>
			<div class="search-container">
				<form action="" method="post">
					Search: <input type="text" id="searchbar" name="search" placeholder="Code or Academic Plan" onkeyup="showRows(this.value)">
				</form>
			 </div>
			<br />
			<br />
			<br />
			
			<!-- Form to go to go create new module page -->
			<form id="newmodule" action="Newmodulepage.php" method="POST">
				<input type="hidden" id="modulecode" name="modulecode" value="" />
				<input type="button" value="Add new module" onclick="gotomoduleeditpage(null)"/>
			</form>
			
			
			<br />
			
			<!-- Start Panel -->
			<div class="panel-wrapper">
				<div class="panel-head">
			<!-- Start Table -->
	
	<div id="ModulesInfo" class="table-wrapper">
		<table class="fl-table">
			<thead>
				<tr>
					<th>Code</th>
					<th>Academic Plan</th>
					<?php
						if($whichschool == "all")
						{
							echo '<th>School</th>';
						}
					?>
				</tr>
			</thead>
			<tbody>
				<?php
					if($whichschool == "all")
					{
						$display = $allmodulequery;
					}
					else
					{
						$display = $specificmodulequery;
					}
					$displaylist = mysqli_query($conn,$display) or die('modules error');
					while($rows = mysqli_fetch_array($displaylist,MYSQLI_ASSOC))
					{
				?>
				<tr>
				<?php
					// main code's information
					echo '<td><a onclick="gotomoduleeditpage(\''.$rows['Code'].'\')" style="cursor: pointer">'.$rows['Code'].'</a></td>';
					echo '<td>'.$rows['Academic Plan'].'</td>';
					
					// if is list of all school, display school as well
					if($whichschool == "all")
					{
						echo '<td>'.$rows['School'].'</td>';
					}
				?>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
	
<script>
var input = document.getElementById("searchbar");
input.addEventListener("keydown", function(event) 
{
  if (event.keyCode === 13) 
  {
    event.preventDefault();
  }
});
</script>

<script>
function gotomoduleeditpage(id)
{
	if(id == null)
	{
		document.getElementById("newmodule").submit();
	}
	else
	{
		document.getElementById("modulecode").value = id;
		document.getElementById("newmodule").submit();
	}
}
</script>

<script>
function showRows(str) 
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
	{
      if (this.readyState == 4 && this.status == 200) 
	  {
        document.getElementById("ModulesInfo").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET", "SearchedModule.php?search=" + str, true);
    xmlhttp.send();
}
</script>

				<!-- End Table -->
				</div>
			</div>
			<!-- End Panel -->
			</div>
</html>