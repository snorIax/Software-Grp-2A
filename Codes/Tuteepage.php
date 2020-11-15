<?php

	include_once('Connection.php');
	
	// Info to be passed around, holds the tutor ID, whether is a senior tutor 
	//and current view whether it's all tutors or just their own tutors (If for senior tutor)
	$userid = $_POST['LectID'];
	$isseniortutor = $_POST['st'];
	$alltuteeslist = $_POST['all'];
	
	$tuteeid = $_POST['tuteeid'];
	
	$tuteequery = mysqli_query($conn, 'SELECT * FROM students WHERE `Student Id` = '.$tuteeid) or die('Tutee error');
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
		</style>
		
	</head>
	
	<body>
	
	<table>
		<tr>
			<td>
				<img style="width:100px;height:125px;">
			</td>
			<td>
				<h2>
					<?php echo $tuteeinfo['First Name']; ?>
				</h2>
				<h3>
					<?php echo $tuteeinfo['Last Name']; ?>
				</h3>
			</td>
		</tr>
	</table>
	
	<br /><br />
	<form action="Newremarkspage.php" method="POST">
		<input type="hidden" name="LectID" value="<?php echo $userid; ?>" />
		<input type="hidden" name="st" value="<?php echo $isseniortutor; ?>" />
		<input type="hidden" name="all" value="<?php echo $alltuteeslist; ?>" />
		<input type="hidden" name="new" value="1" />
		<input type="hidden" name="tuteeid" value="<?php echo $tuteeid; ?>" />
		<input type="submit" value="Add new remarks"/>
	</form>
	<br />
	<table style="width:65%" border="1">
		<tr>
			<td align="center" style="width:15%">
				Date
			</td>
			<td align="center">
				Remarks
			</td>
		</tr>
		<?php
			if($remarksrows == 0)
			{
				echo '<tr><td></td><td align="center"><h4>No Remarks Available</h4></td></tr>';
			}
			else
			{
				while($remarks = mysqli_fetch_array($remarksquery, MYSQLI_ASSOC))
				{
		?>
			<tr>
		<?php
				echo '<td align="center">'.substr($remarks['Date'],0,10).'</td>';
				echo '<td>'.$remarks['Remarks'].'</td>';
				echo '<td align="center">
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
	<br />
	<br />
	<br />
	<form action="Tutorpage.php" method="POST">
		<input type="hidden" name="LectID" value="<?php echo $userid; ?>" />
		<input type="hidden" name="st" value="<?php echo $isseniortutor; ?>" />
		<input type="hidden" name="all" value="<?php echo $alltuteeslist; ?>" />
		<input type="submit" value="Back to list"/>
	</form>
	
	</body>
	
</html>