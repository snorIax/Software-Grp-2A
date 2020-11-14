<?php

	include_once('Connection.php');
	

	$userid = $_POST['LectID'];
	$isseniortutor = $_POST['st'];
	$alltuteeslist = $_POST['all'];
	
	$schoolquery = mysqli_query($conn,'SELECT School FROM `tutors` WHERE `Lect ID` = '.$userid) or die('school error');
	$school = mysqli_fetch_array($schoolquery, MYSQLI_ASSOC);
	
	$theirtutees = mysqli_query($conn,'SELECT * FROM `students` WHERE `Tutor Id` = '.$userid) or die('their tutees error');
	$alltutees = mysqli_query($conn,'SELECT * FROM `students` INNER JOIN `academic plan codes` ON `students`.`Academic Plan Code` = `academic plan codes`.`Code` WHERE School LIKE "'.$school['School'].'"') or die('all tutees error');

?>

<!DOCTYPE html>
<html>
	<head>
		<title>
			Tutors
		</title>
	</head>
	<body>
	
		<table border="1">
			<tr >
				<td align="center"><strong>ID</strong></td>
				<td align="center"><strong>Name</strong></td>
			</tr>
			<?php
				if($alltuteeslist)
				{
					$displaylist = $alltutees;
				}
				else
				{
					$displaylist = $theirtutees;
				}
				while($rows = mysqli_fetch_array($displaylist,MYSQLI_ASSOC))
			    {
			?>
				<tr>
				<?php
					echo '<td align="center">'.$rows['Student Id'].'</td>';
					echo '<td align="center">'.$rows['Full Name'].'</td>';
				?>
				</tr>
			<?php
				}
			?>
		</table>
		
		<form method="post" action="" id="logindata">
		<?php
			if ($isseniortutor)
			{
				if ($alltuteeslist)
				{
					echo '<input type="button" value="see personal tutees" onclick="changelist()" />';
					$check = 0;
				}
				else
				{
					echo '<input type="button" value="see all tutees" onclick="changelist()" />';
					$check = 1;
				}
			}
		?>
			<input type="hidden" name="LectID" value="<?php echo $userid; ?>" />
			<input type="hidden" name="st" value="<?php echo $isseniortutor; ?>" />
			<input type="hidden" id="all" name="all" value="" />
		</form>
		
		<form method="post" action="Loginpage.php">
			<input type="submit" value="Logout">
		</form>
		
<script>
function changelist()
{
	document.getElementById("all").value = <?php echo $check; ?>;
    document.getElementById("logindata").submit();
}
</script>

	</body>
</html>