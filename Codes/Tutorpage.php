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
	
	// Query to look for the current school association
	$schoolquery = mysqli_query($conn,'SELECT School FROM `tutors` WHERE `Lect ID` = '.$userid) or die('school error');
	$school = mysqli_fetch_array($schoolquery, MYSQLI_ASSOC);
	
	// Query to look for the tutees of their specific tutees or all tutees under the same school
	$theirtutees = mysqli_query($conn,'SELECT * FROM `students` WHERE `Tutor Id` = '.$userid) or die('their tutees error');
	$alltutees = mysqli_query($conn,'SELECT * FROM `students` INNER JOIN `academic plan codes` ON `students`.`Academic Plan Code` = `academic plan codes`.`Code` WHERE School LIKE "'.$school['School'].'"') or die('all tutees error');
	
	//List of tutors under the same school
	$schooltutors = 'SELECT * FROM `tutors` WHERE School LIKE "'.$school['School'].'"';
	$changedatalist = mysqli_query($conn,$schooltutors);

?>

<!DOCTYPE html>
<html>
	<head>
	
		<title>
			Tutors
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
			width:20%;
			height:23%;
			position:relative;
			transition:all 5s ease-in-out;
		}
		
		.popupconfirm
		{
			margin:225px auto;
			padding:15 30 30;
			background:white;
			border-radius:5px;
			width:25%;
			height:25%;
			position:relative;
			transition:all 5s ease-in-out;
		}
		</style>
		
	</head>
	<body>
	
		<table border="1">
			<tr >
				<td align="center"><strong>ID</strong></td>
				<td align="center"><strong>Name</strong></td>
				<?php
					if($alltuteeslist)
					{
						echo '<td align="center"><strong>Tutor Id</strong></td>';
					}
				?>
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
					// main student's information
					echo '<td align="center"><a onclick="gototuteepage('.$rows['Student Id'].')" style="cursor: pointer">'.$rows['Student Id'].'</a></td>';
					echo '<td align="center">'.$rows['Full Name'].'</td>';
					
					// if is list of all tutees, display tutors and changing option
					if($alltuteeslist)
					{
						echo '<td align="center">'.$rows['Tutor Id'].'</td>';
						echo '<td align="center">
								<form id="'.$rows['Student Id'].'" action="#changetutor" method="POST">
    						        <input type="hidden" name="studentid" value="'.$rows['Student Id'].'"/>
    						        <input type="hidden" name="tutorid" value="'.$rows['Tutor Id'].'"/>
        							
									<input type="hidden" name="LectID" value="'.$userid.'" />
									<input type="hidden" name="st" value="'.$isseniortutor.'" />
									<input type="hidden" name="all" value="'.$alltuteeslist.'" />
									
									<input type="submit" value="Change tutor" />
    						    </form>
							</td>';
					}
				?>
				</tr>
			<?php
				}
			?>
		</table>
		
		<!-- form to pass around login info -->
		<form action="" method="POST" id="logindata">
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
		
		<!-- form to pass around tutee page info -->
		<form method="POST" id="tuteedata" action="Tuteepage.php">
			<input type="hidden" name="LectID" value="<?php echo $userid; ?>" />
			<input type="hidden" name="st" value="<?php echo $isseniortutor; ?>" />
			<input type="hidden" name="all" value="<?php echo $alltuteeslist; ?>" />
			<input type="hidden" id="tuteeid" name="tuteeid" value="" />
		</form>
		
		<!-- form for logout -->
		<form method="POST" action="Loginpage.php">
			<input type="submit" value="Logout">
		</form>
		
<div id="changetutor" class="overlay">
	<div class="popupchange">
		<table>
			<tr>
				<td><h3>Change to which tutor?</h3></td>
				<td><a class="close" href="#">&times;<br /></a></td>
			</tr>
			<tr>
				<td colspan="2">
					<form action="#confirmchange" method="POST">
						<label>
							Tutor:<br />
						</label>
						<input list="tutorid" name="tutoridfinal" placeholder="<?php echo $_POST['tutorid']; ?>" required="required">
							<datalist id="tutorid">
    						<?php
    			                while($rows = mysqli_fetch_array($changedatalist))
    			                {
									if($rows['Lect ID'] != $_POST['tutorid'])
									{
    			            ?>
    			                <option value="<?php echo $rows['Lect ID']; ?>"><?php echo $rows['Name']; ?></option>
    			            <?php
									}
    			                }
    			            ?>
			                </datalist>
						<br /><br />
						<label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="hidden" name="studentidfinal" value="<?php echo $_POST['studentid']; ?>" />
							<input type="hidden" name="LectID" value="<?php echo $userid; ?>" />
							<input type="hidden" name="st" value="<?php echo $isseniortutor; ?>" />
							<input type="hidden" name="all" value="<?php echo $alltuteeslist; ?>" />
							<input type="submit" value="Confirm"/>
						</label>		
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>


<div id="confirmchange" class="overlay">
	<div class="popupconfirm">
		<table>
			<tr>
				<td><h3>Confirmation</h3></td>
				<td><a class="close" href="#">&times;<br /></a></td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<?php
						include('TutorChange.php');
					?>
					<form id="confirm" action="#" method="POST">
						<input type="hidden" name="LectID" value="<?php echo $userid; ?>" />
						<input type="hidden" name="st" value="<?php echo $isseniortutor; ?>" />
						<input type="hidden" name="all" value="<?php echo $alltuteeslist; ?>" />
						<input type="submit" value="Ok" />
					</form>
				</td>
			</tr>
		</table>
	</div>
</div>

		
<script>
function changelist()
{
	document.getElementById("all").value = <?php echo $check; ?>;
    document.getElementById("logindata").submit();
}
</script>

<script>
function gototuteepage(id)
{
	document.getElementById("tuteeid").value = id;
    document.getElementById("tuteedata").submit();
}
</script>

	</body>
</html>