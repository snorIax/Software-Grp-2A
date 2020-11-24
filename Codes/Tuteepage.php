<?php

	include_once('Connection.php');
	
	// Info to be passed around, holds the tutor ID, whether is a senior tutor 
	//and current view whether it's all tutors or just their own tutors (If for senior tutor)
	$userid = $_POST['LectID'];
	$isseniortutor = $_POST['st'];
	$alltuteeslist = $_POST['all'];
	
	// If haven't login, then change to login page
	if(!(isset($userid)))
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
	
		<title>
			Tutee
		</title>
		
		<style>
		.remarks
		{
			border-collapse:collapse;
		}
		
		.cover
		{
			border-style:solid;
			border-color:black;
			border-width:1px;
		}
		</style>
		
	</head>
	
	<body>
	
	<table align="center" border="0">
		<tr>
			<td align="center">
				<img style="width:100px;height:125px;">
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
					<input type="hidden" name="LectID" value="<?php echo $userid; ?>" />
					<input type="hidden" name="st" value="<?php echo $isseniortutor; ?>" />
					<input type="hidden" name="all" value="<?php echo $alltuteeslist; ?>" />
					<input type="hidden" name="new" value="1" />
					<input type="hidden" name="tuteeid" value="<?php echo $tuteeid; ?>" />
					<input type="submit" value="Add new remarks"/>
				</form>
			</td>
		</tr>
	</table>
	
	<br />
	
	<table style="width:60%" align="center" class="remarks">
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
							
							<input type="hidden" name="LectID" value="'.$userid.'" />
							<input type="hidden" name="st" value="'.$isseniortutor.'" />
							<input type="hidden" name="all" value="'.$alltuteeslist.'" />
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
	
	<br /><br /><br /><br /><br />
	
	<form action="Tutorpage.php" method="POST">
		<input type="hidden" name="LectID" value="<?php echo $userid; ?>" />
		<input type="hidden" name="st" value="<?php echo $isseniortutor; ?>" />
		<input type="hidden" name="all" value="<?php echo $alltuteeslist; ?>" />
		<input type="submit" value="Back to list"/>
	</form>
	
	<form id="BacktoLogin" action="Loginpage.php">
	</form>
	
	</body>
	
</html>