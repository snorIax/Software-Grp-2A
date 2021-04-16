<?php

include_once('Connection.php');

// Info to be passed around, holds the tutor ID
$userid = $_GET['LectID'];

$getTutorID = $userid;

$tutorNameQuery = 'SELECT tutors.`Name` FROM `tutors` WHERE `Lect ID` = '.$userid.'';
$getTutorName = mysqli_query($conn, $tutorNameQuery) or die("Error fetching tutor's name.");
$name = mysqli_fetch_array($getTutorName, MYSQLI_ASSOC);

$tutorEmailQuery = 'SELECT tutors.`email` FROM `tutors` WHERE `Lect ID` = '.$userid.'';
$getTutorEmail = mysqli_query($conn, $tutorEmailQuery) or die("Error fetching tutor's email.");
$email = mysqli_fetch_array($getTutorEmail, MYSQLI_ASSOC);

$tutorSchoolQuery = 'SELECT tutors.`School` FROM `tutors` WHERE `Lect ID` = '.$userid.'';
$getTutorSchool = mysqli_query($conn, $tutorSchoolQuery) or die("Error fetching tutor's school.");
$school = mysqli_fetch_array($getTutorSchool, MYSQLI_ASSOC);

$tutorOfficeQuery = 'SELECT tutors.`office` FROM `tutors` WHERE `Lect ID` = '.$userid.'';
$getTutorOffice = mysqli_query($conn, $tutorOfficeQuery) or die("Error fetching tutor's office.");
$office = mysqli_fetch_array($getTutorOffice, MYSQLI_ASSOC);

$seniorTutorsListQuery = 'SELECT `Lect ID` FROM `senior tutors`';
$getSeniorTutors = mysqli_query($conn, $seniorTutorsListQuery) or die("Error fetching tutor's name.");
$seniorTutorsList = mysqli_fetch_array($getSeniorTutors, MYSQLI_NUM);

while($data = mysqli_fetch_array($getSeniorTutors, MYSQLI_NUM)){
  if(in_array($userid, $data)) {
      $tutorPosition = "Senior Tutor";
    } else {
      $tutorPosition = "Regular Tutor";
    }
}


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
					<li><a href="Tutorpage.php">Tutees</a></li>
 					<li><a href="loginpage.php">Log Out</a></li>
 				</ul>

 			</nav>

 		</div>
 	<!-- End Menu -->

 	  <div class="main-content">
 				<h3><b>Profile Page of <?php echo $name['Name'] ?> </b></h3>
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

        <strong>Lecturer ID: </strong> <?php echo $getTutorID ?> </br>
        <strong>Name: </strong> <?php echo $name['Name'] ?> </br>
        <strong>Email: </strong> <?php echo $email['email'] ?> </br>

        <br>
        <br>

      </p>

      <p><strong> <u> Academic Information </u> </strong></br></p>
  		<p>

         <strong>School: </strong> <?php echo $school['School'] ?> </br>
         <strong>Office Location: </strong> <?php echo $office['office'] ?> </br>
         <strong>Tutor Position: </strong> <?php echo $tutorPosition ?> </br>

       </p>

 		<br>
 		<br>


 	<!-- Hidden form that echoes (returns) the user id -->
 	<form action="Tutorpage.php">
        <input type="submit" value="Back">
    </form>


 					<!-- End Table -->
 					</div>
 				</div>
 				<!-- End Panel -->
 				</div>
 	</body>
 </html>
 <!-- End of HTML script -->
