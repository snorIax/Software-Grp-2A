<?php

	session_start();

	include_once('Connection.php'); //to connect the page to the database

	// If haven't login, then change to login page
	if((!(isset($_SESSION['userid']))) or ($_SESSION['category'] != "Student"))
	{
		header("Location:Loginpage.php");
	}

	$userid = $_GET['studentID'];

	// if(!empty($_POST['submit'])){
	//   $userid = $_POST['studentID'];
	//   $_SESSION['studentID'] = $userid;
	// }


	$getStudentID = $userid;

	$firstNameQuery = 'SELECT students.`First Name` FROM `students` WHERE `Student Id` = '.$userid.'';
	$getStudentFirstName = mysqli_query($conn, $firstNameQuery) or die("Error fetching student's first name.");
	$firstName = mysqli_fetch_array($getStudentFirstName,MYSQLI_ASSOC);

	$lastNameQuery = 'SELECT students.`Last Name` FROM `students` WHERE `Student Id` = '.$userid.'';
	$getStudentLastName = mysqli_query($conn, $lastNameQuery) or die("Error fetching student's last name.");
	$lastName = mysqli_fetch_array($getStudentLastName,MYSQLI_ASSOC);


	$nationalityQuery = 'SELECT students.`Nationality` FROM `students` WHERE `Student Id` = '.$userid.'';
	$getStudentNationality = mysqli_query($conn, $nationalityQuery) or die("Error fetching student's last name.");
	$nationality = mysqli_fetch_array($getStudentNationality,MYSQLI_ASSOC);

	$emailQuery = 'SELECT students.`Email Address` FROM `students` WHERE `Student Id` = '.$userid.'';
	$getStudentEmail = mysqli_query($conn, $emailQuery) or die("Error fetching student's email.");
	$email = mysqli_fetch_array($getStudentEmail,MYSQLI_ASSOC);

	//Academic Information

	$academicPlanCodeQuery = 'SELECT students.`Academic Plan Code` FROM `students` WHERE `Student Id` = '.$userid.'';
	$getStudentAcademicPlanCode = mysqli_query($conn, $academicPlanCodeQuery) or die("Error fetching student's academic plan code.");
	$academicPlanCode = mysqli_fetch_array($getStudentAcademicPlanCode,MYSQLI_ASSOC);

	$academicPlanQuery = 'SELECT `academic plan codes`.`Academic Plan` FROM `academic plan codes` JOIN students ON students.`Academic Plan Code` = `academic plan codes`.`Code` WHERE students.`Student Id` ='.$userid.'';
	$getStudentAcademicPlan = mysqli_query($conn, $academicPlanQuery) or die("Error fetching student's academic plan.");
	$academicPlan = mysqli_fetch_array($getStudentAcademicPlan,MYSQLI_ASSOC);

	$currentYearQuery = 'SELECT students.`Current Year` FROM `students` WHERE `Student Id` = '.$userid.'';
	$getStudentCurrentYear = mysqli_query($conn, $currentYearQuery) or die("Error fetching student's currnt year.");
	$currentYear = mysqli_fetch_array($getStudentCurrentYear,MYSQLI_ASSOC);

	$levelQuery = 'SELECT students.`Level` FROM `students` WHERE `Student Id` = '.$userid.'';
	$getStudentLevel = mysqli_query($conn, $levelQuery) or die("Error fetching level.");
	$level = mysqli_fetch_array($getStudentLevel,MYSQLI_ASSOC);

	$registrationDateQuery = 'SELECT students.`Registration Date` FROM `students` WHERE `Student Id` = '.$userid.'';
	$getStudentRegistrationDate = mysqli_query($conn, $registrationDateQuery) or die("Error fetching student's registration date.");
	$registrationDate = mysqli_fetch_array($getStudentRegistrationDate,MYSQLI_ASSOC);


?>

<!-- start of the HTML script for the student view page  -->

 <!DOCTYPE html>
 <html>
  <head>
	<link rel="stylesheet" href="default.css">
    <title> Student Information </title>
  </head>

<body>
<!-- Start Menu -->
	<div class="nav-btn">Menu</div>
	<div class="container">
		<div class="sidebar">

			<nav>
				<a href="#">Nottingham <span>Tutor System</span></a>
				<ul>
					<li><a href="StudentView.php">List</a></li>
					<li><a href="Loginpage.php">Log Out</a></li>
				</ul>

			</nav>

		</div>
	<!-- End Menu -->

	  <div class="main-content">
				<h3><b>Profile Page of <?php echo $firstName['First Name']. ' '. $lastName['Last Name'] ?> </b></h3>
				<br>
			<!--	<div class="search-container">
					<form action="" method="post">
						Search: <input type="text" name="search" placeholder="Student ID or Name" onkeyup="showRows(this.value)">
					</form>
				 </div>
				<br> -->
				<br>
				<!-- Start Panel -->
				<div class="panel-wrapper">
					<div class="panel-head">
				<!-- Start Table -->


		<!-- displaying students information -->


<table class="fl-table">
  <thead>
   <tr><th> <p><strong> My Profile </strong> </br> </p></th></tr>
  </thead>
  </table>
  <p><strong><u> Personal Information </u></strong></br></p>
		<p>

       <strong>Student ID: </strong> <?php echo $getStudentID ?> </br>
       <strong>First Name: </strong> <?php echo $firstName['First Name'] ?> </br>
       <strong>Last Name: </strong> <?php echo $lastName['Last Name'] ?> </br>
       <strong>Nationality: </strong> <?php echo $nationality['Nationality'] ?> </br>
       <strong>Email: </strong> <?php echo $email['Email Address'] ?> </br>

       <br>
       <br>

     </p>

     <p><strong> <u> Academic Information </u> </strong></br></p>
 		<p>

        <strong>Academic Plan Code: </strong> <?php echo $academicPlanCode['Academic Plan Code'] ?> </br>
        <strong>Academic Plan: </strong> <?php echo $academicPlan['Academic Plan'] ?> </br>
        <strong>Level: </strong> <?php echo $level['Level'] ?> </br>
        <strong>Current Year: </strong> <?php echo $currentYear['Current Year'] ?> </br>
        <strong>Registration Date: </strong> <?php echo $registrationDate['Registration Date'] ?> </br>

      </p>

		<br>
		<br>


	<!-- Hidden form that echoes (returns) the user id -->
		 <form>
       <input type="button" value="Back" onclick="history.back()">
     </form>


					<!-- End Table -->
					</div>
				</div>
				<!-- End Panel -->
				</div>
	</body>
</html>
<!-- End of HTML script -->
