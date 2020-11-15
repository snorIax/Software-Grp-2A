<?php

	include_once('Connection.php');
	
	error_reporting(0);

	$userid = $_POST['LectID'];
	$isseniortutor = $_POST['st'];
	$alltuteeslist = $_POST['all'];
	
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
	
		<title>
			New Remarks
		</title>
		
		<style>
		</style>
		
	</head>
	
	<body>

		<form id="remarksform" action="" method="POST">
			<input type="hidden" name="LectID" value="<?php echo $userid; ?>" />
			<input type="hidden" name="st" value="<?php echo $isseniortutor; ?>" />
			<input type="hidden" name="all" value="<?php echo $alltuteeslist; ?>" />
			<input type="hidden" name="tuteeid" value="<?php echo $tuteeid; ?>" />
			<input type="hidden" name="timestamp" value="<?php echo $date; ?>" />
			
			<span><b>Remarks:</b></span>
			<br />
			<textarea name="remarks" rows="10" cols="100"><?php if($new == NULL){echo $remarks;} ?></textarea>
			<br />
			<?php
				if(isset($new))
				{
					echo '<input type="hidden" name="new" value="1" />';
					echo '<input type="submit" value="Add remarks"/>';
				}
				else
				{
					echo '<input type="hidden" id="editordelete" name="" value="1" />';
					echo '<input type="button" value="Edit remarks" onclick="toedit()" />';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '<input type="button" value="Delete remarks" onclick="todelete()" />';
				}
			?>
		</form>
		
		<!-- form to pass details back to tutee page-->
		<form id="alldata" action="Tuteepage.php" method="POST">
			<input type="hidden" name="LectID" value="<?php echo $userid; ?>" />
			<input type="hidden" name="st" value="<?php echo $isseniortutor; ?>" />
			<input type="hidden" name="all" value="<?php echo $alltuteeslist; ?>" />
			<input type="hidden" id="tuteeid" name="tuteeid" value="<?php echo $tuteeid; ?>" />
		</form>
		
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
function toedit()
{
	document.getElementById("editordelete").name = "edit";
	document.getElementById("remarksform").submit();
}
</script>

<script>
function todelete()
{
	document.getElementById("editordelete").name = "delete";
	document.getElementById("remarksform").submit();
}
</script>
	
	</body>
	
</html>