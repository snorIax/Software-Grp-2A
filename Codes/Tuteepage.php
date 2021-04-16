<?php
	session_start();

	include_once('Connection.php');
	
	// If haven't login, then change to login page
	if((!(isset($_SESSION['userid']))) or ($_SESSION['category'] != "Tutor"))
	{
		header("Location:Loginpage.php");
	}
	
	$tuteeid = $_POST['tuteeid'];
	
	$tuteequery = mysqli_query($conn, 'SELECT * FROM students INNER JOIN `academic plan codes` ON students.`Academic Plan Code` = `academic plan codes`.Code WHERE `Student Id` = '.$tuteeid) or die('Tutee error');
	$tuteeinfo = mysqli_fetch_array($tuteequery, MYSQLI_ASSOC);
	
	$remarksquery = mysqli_query($conn, 'SELECT * FROM remarks WHERE `Student Id` = '.$tuteeid) or die('Remarks error');
	$remarksrows = mysqli_num_rows($remarksquery);

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="default.css">
	
		<title>
			Tutee
		</title>
		
		<style>
		.remarks
		{
			margin-left:auto;
			margin-right:auto;
			border-collapse:collapse;
		}
		
		.cover
		{
			border-style:solid;
			border-color:black;
			border-width:1px;
		}
		
		.info
		{
			margin-left:auto;
			margin-right:auto;
			padding: 0;
		}
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
			width:20%;
			height:35%;
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
	
	<body>
	
	<!-- Start Menu -->
	<div class="nav-btn">Menu</div>
	<div class="container">
		<div class="sidebar">
		
			<nav>
				<a href="#">Nottingham <span>Tutor System</span></a>
				
				<ul>
					<li><a href="Tutorpage.php">Tutees</a></li>
					<li><a href="Loginpage.php">Log Out</a></li>
				</ul>
			</nav>
			
		</div>

	<!-- End Menu -->
	
	<div class="main-content">
	
	<!-- Start Panel -->
		<div class="panel-wrapper">
			<div class="panel-head">
	
				<table class="info" border="0">
					<tr>
						<td align="center" valign="middle">
							<img style="width:100px;height:125px;margin-top:10px;margin-bottom:10px;">
						</td>
						<td>
							<h1>
								<?php echo $tuteeinfo['First Name']; ?>
							</h1>
							<h3>
								<?php echo $tuteeinfo['Last Name']; ?>
							</h3>
							<h3>
								<?php echo $tuteeinfo['Student Id']; ?>
							</h3>
						</td>
					</tr>
					<tr>
						<td align="center">
							<strong>
								Gender:
							</strong>
						</td>
						<td>
							<span>
								<?php echo $tuteeinfo['Gender']; ?><br />
							</span>
						</td>
					</tr>
					<tr>
						<td align="center">
							<strong>
								Nationality:
							</strong>
						</td>
						<td>
							<span>
								<?php echo $tuteeinfo['Nationality']; ?>
							</span>
						</td>
					</tr>
					<tr>
						<td align="center">
							<strong>
								Academic Plan:
							</strong>
						</td>
						<td>
							<span>
								<?php echo $tuteeinfo['Academic Plan']; ?>
							</span>
						</td>
					</tr>
					<tr>
						<td align="center">
							<strong>
								Intake / Registration Date: &nbsp;&nbsp;
							</strong>
						</td>
						<td>
							<span>
								<?php echo $tuteeinfo['Intake']; ?> (<?php echo $tuteeinfo['Registration Date']; ?>)
							</span>
						</td>
					</tr>
					<tr>
						<td align="center">
							<strong>
								Current Level:
							</strong>
						</td>
						<td>
							<span>
								<?php echo $tuteeinfo['Level']; ?> <?php if ($tuteeinfo['Level'] == "Undergraduate") { echo "Year ".$tuteeinfo['Current Year']; } ?>
							</span>
						</td>
					</tr>
					<tr>
						<td align="center">
							<strong>
								Email:
							</strong>
						</td>
						<td>
							<span>
								<?php echo $tuteeinfo['Email Address']; ?>
							</span>
						</td>
					</tr>
				</table>
				
				<br /><br /><br />
				
				<table align="center">
					<tr>
						<td>
							<form action="Newremarkspage.php" method="POST">
								<input type="hidden" name="new" value="1" />
								<input type="hidden" name="tuteeid" value="<?php echo $tuteeid; ?>" />
								<input type="submit" value="Add new remarks"/>
							</form>
						</td>  
					</tr>
					<?php
					if($tuteeinfo['Current Year'] < 6)
					{
						echo '<tr>
							<td>
								<form action="#progression" method="POST">
									<input type="hidden" name="tuteeid" value="'.$tuteeid.'" />
									<input class="progression" type="submit" value="Progress student"/>
								</form>
							</td>
						</tr>';
					}
					?>
				</table>
				
				<br />
				
				<table style="width:90%" align="center" class="remarks">
					<tr>
						<td align="center" style="width:15%" class="cover">
							Date
						</td>
						<td align="center" class="cover">
							Remarks
						</td>
					</tr>
					<?php
						if($remarksrows == 0)
						{
							echo '<tr><td colspan="2" align="center" class="cover"><h4>No Remarks Available</h4></td></tr>';
						}
						else
						{
							while($remarks = mysqli_fetch_array($remarksquery, MYSQLI_ASSOC))
							{
					?>
						<tr>
					<?php
							echo '<td align="center" class="cover">'.substr($remarks['Date'],0,10).'</td>';
							echo '<td class="cover">'.$remarks['Remarks'].'</td>';
							echo '<td align="center" width="10%" style="border:none">
									<form action="Newremarkspage.php" method="POST">
							
										<input type="hidden" name="tuteeid" value="'.$tuteeid.'" />
										<input type="hidden" name="remarks" value="'.$remarks['Remarks'].'" />
										<input type="hidden" name="timestamp" value="'.$remarks['Date'].'" />
										
										<input type="submit" value="Edit remarks" />
									</form>
								</td>';
					?>
						</tr>
					<?php
							}
						}
					?>
				</table>
			</div>
            
            <div id="progression" class="overlay">
                <div class="popupchange">
                    <table style="margin-top: 100%">
                        <tr>
                            <td align="center"><h3 style="margin-top:20%">What year is the student progressing to?</h3></td>
                            <td><a class="close" href="#">&times;<br /></a></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <form action="#confirmtutor" method="POST">
								
                                Name:&nbsp;&nbsp;<strong><?php echo $tuteeinfo['First Name']; ?>&nbsp;<?php echo $tuteeinfo['Last Name']; ?></strong>
                                <br /><br />
                                <label>
								Progressing to year:&nbsp;&nbsp;
								<br />
                                </label>
								<select id="progressingyear" name="progressingyear">
								<?php 
									if($tuteeinfo['Level'] == "Foundation") //foundation to undergrad
									{
										echo '<option value="1">Year 1</option>';
									}   
									else if($tuteeinfo['Current Year'] == 1) //first year to second
									{   
										echo '<option value="2">Year 2</option>';
									}   
									else if($tuteeinfo['Current Year'] == 2) //second year to third
									{   
										echo '<option value="3">Year 3</option>';
									}   
									else if($tuteeinfo['Current Year'] == 3) //third year to either fourth year or postgrad but idk how to do that
									{ 
										echo '<option value="4">Year 4</option>';
										echo '<option value="6">Postgraduate Taught</option>';
										echo '<option value="7">Postgraduate Research</option>';
									}
									else if($tuteeinfo['Current Year'] == 4)
									{
										echo '<option value="6">Postgraduate Taught</option>';
										echo '<option value="7">Postgraduate Research</option>';
									}
								?>
								</select>
								<br />
                                <input type="hidden" name="studentidfinal" value="<?php echo $tuteeid; ?>" />
								<input type="hidden" name="tuteeid" value="<?php echo $tuteeid; ?>" />
                                <input type="submit" value="Confirm"/>
								
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
                        
		</div>
	</div>
    
 <div id="confirmtutor" class="overlay">
	<div class="popupconfirm">
		<table>
			<tr>
				<td><h3>Confirmation</h3></td>
				<td><a class="close" href="#">&times;<br /></a></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<?php
						include('Progression.php');
					?>
					<form id="confirm" action="#" method="POST">
						<input type="hidden" name="tuteeid" value="<?php echo $tuteeid; ?>" />
						<input type="submit" value="Ok" />
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>
	
	</body>
	
</html>