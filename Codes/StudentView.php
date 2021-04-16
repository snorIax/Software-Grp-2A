<?php
//start of PHP script
	session_start();

	//to connect the page to the database
	include_once('Connection.php');

	// If haven't login, then change to login page
	if((!(isset($_SESSION['userid']))) or ($_SESSION['category'] != "Student"))
	{
		header("Location:Loginpage.php");
	}

	//storing the student ID that the student entered at the log in page in the studentid variable
	$userid = $_SESSION['userid'];

	// an sql query to get the tutor ID
	$getTutorID = mysqli_query($conn, 'SELECT tutors.`Lect ID` FROM tutors JOIN students ON students.`Tutor Id` = tutors.`Lect ID` WHERE students.`Student Id`= ' .$userid) or die('Error Fetching Tutor ID');
	//fetching the tutor ID received from the query
	$tutorID = mysqli_fetch_array($getTutorID,MYSQLI_ASSOC);

	//an sql query to get all students under the same tutor in the same year
	$query = 'SELECT students.`Student Id`, students.`First Name`, students.`Last Name`, `academic plan codes`.`Academic Plan`, students.`Current Year` FROM `academic plan codes` JOIN students ON students.`Academic Plan Code` = `academic plan codes`.`Code` WHERE students.`Tutor Id` LIKE '.$tutorID['Lect ID'].' AND students.`Student Id` NOT LIKE '.$userid.' AND students.`Current Year` LIKE (SELECT students.`Current Year` FROM students WHERE students.`Student Id` LIKE '.$userid.')';
	$studentsUnderSameTutor = mysqli_query($conn, $query) or die("Error fetching students data.");

	//sql query to get the tutor's name
	$getTutorName = mysqli_query($conn, 'SELECT tutors.`Name` FROM tutors JOIN students ON students.`Tutor Id` = tutors.`Lect ID` WHERE students.`Student Id`= ' .$userid) or die('Error Fetching Tutor Name');
	//fetching the tutor name received from the query
	$tutorName = mysqli_fetch_array($getTutorName,MYSQLI_ASSOC);

	//sql query to get the tutor's school
	$getTutorSchool = mysqli_query($conn, 'SELECT tutors.`School` FROM tutors JOIN students ON students.`Tutor Id` = tutors.`Lect ID` WHERE students.`Student Id`= ' .$userid) or die('Error Fetching Tutor Name');
	//fetching the tutor's school received from the query
	$tutorSchool = mysqli_fetch_array($getTutorSchool,MYSQLI_ASSOC);

	//sql query to get the tutor's email
	$getTutorEmail = mysqli_query($conn, 'SELECT tutors.`email` FROM tutors JOIN students ON students.`Tutor Id` = tutors.`Lect ID` WHERE students.`Student Id`= ' .$userid) or die('Error Fetching Tutor Name');
	//fetching the tutor's email received from the query
	$tutorEmail = mysqli_fetch_array($getTutorEmail,MYSQLI_ASSOC);

	//sql query to get the tutor's office
	$getTutorOffice = mysqli_query($conn, 'SELECT tutors.`office` FROM tutors JOIN students ON students.`Tutor Id` = tutors.`Lect ID` WHERE students.`Student Id`= ' .$userid) or die('Error Fetching Tutor Name');
	//fetching the tutor's office received from the query
	$tutorOffice = mysqli_fetch_array($getTutorOffice,MYSQLI_ASSOC);

	//query to get first name
	$firstNameQuery = 'SELECT students.`First Name` FROM `students` WHERE `Student Id` = '.$userid.'';
	$getStudentFirstName = mysqli_query($conn, $firstNameQuery) or die("Error fetching student's first name.");
	$firstName = mysqli_fetch_array($getStudentFirstName,MYSQLI_ASSOC);

  //query to get last name
	$lastNameQuery = 'SELECT students.`Last Name` FROM `students` WHERE `Student Id` = '.$userid.'';
	$getStudentLastName = mysqli_query($conn, $lastNameQuery) or die("Error fetching student's last name.");
	$lastName = mysqli_fetch_array($getStudentLastName,MYSQLI_ASSOC);

 //query to get academic plan
	$academicPlanQuery = 'SELECT `academic plan codes`.`Academic Plan` FROM `academic plan codes` JOIN students ON students.`Academic Plan Code` = `academic plan codes`.`Code` WHERE students.`Student Id` ='.$userid.'';
	$getStudentAcademicPlan = mysqli_query($conn, $academicPlanQuery) or die("Error fetching student's academic plan.");
	$academicPlan = mysqli_fetch_array($getStudentAcademicPlan,MYSQLI_ASSOC);

//end of PHP script
 ?>

<!-- start of the HTML script for the student view page  -->

 <!DOCTYPE html>
 <html>
  <head>
	<link rel="stylesheet" href="default.css">
    <title> Student Page </title>
  </head>

<body>
<!-- Start Menu -->
	<div class="nav-btn">Menu</div>
	<div class="container">
		<div class="sidebar">

			<nav>
				<a href="#">Notts<span>Tutor</span></a>
				<ul>
					<li><a href="UserInformationStudent.php?studentID=<?php echo $userid ?>">Profile</a></li>
					<li><a href="Loginpage.php">Log Out</a></li>
				</ul>

			</nav>

		</div>
	<!-- End Menu -->

	  <div class="main-content">
				<h3><b>Student Page of <?php echo $firstName['First Name']. ' '.$lastName['Last Name'] ?>
				</b></h3>
				<h3> <b> Your Academic Plan: </b> <?php echo $academicPlan['Academic Plan'] ?> <h3>
				<br>
				<div class="search-container">
					<form action="" method="post">
						Search: <input type="text" name="search" placeholder="Student ID or Name" onkeyup="showRows(this.value)">
					</form>
				 </div>
				<br>
				<br>
				<!-- Start Panel -->
				<div class="panel-wrapper">
					<div class="panel-head">
				<!-- Start Table -->

		<!-- Displaying the tutor's information received from the queries -->
		<p><u> <strong> Your Tutor: </strong> </br> </u> </p>
		<p><strong>Tutor's Name: </strong> <?php echo $tutorName['Name'] ?> </br> <strong>Tutor's Email: </strong> <?php echo $tutorEmail['email'] ?> </br>
		<strong>Tutor's School: </strong> <?php echo $tutorSchool['School'] ?> </br> <strong>Tutor's Office: </strong> <?php echo $tutorOffice['office'] ?> </br></p>

	<!--Displaying the list of students under the same tutor and their information -->
		<br>
		<p> <strong> List of students under the same tutor: </strong> </p>
		<br>
		<!-- Creating the table and its rows -->
		<table class="fl-table">
			<thead>
				  <tr>
					<th><strong>ID</strong></th>
					<th><strong>First Name</strong></th>
					<th><strong>Last Name</strong></th>
					<th><strong>Academic Plan</strong></th>
				  </tr>
			</thead>
		<!--Placing the student data into the rows of the table -->
			<tbody>
			  <?php
			  $studentsList = $studentsUnderSameTutor;
			  while ($rows = mysqli_fetch_array($studentsList,MYSQLI_ASSOC)) {
				?>

				<tr>
				  <?php
				   echo '<td>'.$rows['Student Id'].'</td>';
				   echo '<td>'.$rows['First Name'].'</td>';
				   echo '<td>'.$rows['Last Name'].'</td>';
				   echo '<td>'.$rows['Academic Plan'].'</td>';
				  ?>
				</tr>
				<?php
			  }
			   ?>
			</tbody>
		 </table>

	<!-- Hidden form that echoes (returns) the user id -->
		 <form method="post" action="UserInformationStudent.php">
		   <input type="hidden" name="studentID" id="studentID" value="<?php echo $userid; ?>" />
			</form>

					<!-- End Table -->
					</div>
				</div>
				<!-- End Panel -->
				</div>
	</body>
</html>
<!-- End of HTML script -->
