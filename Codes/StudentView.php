<?php
//start of PHP script

include_once('Connection.php'); //to connect the page to the database

$userid = $_POST['studentID']; //storing the student ID that the student entered at the log in page in the studentid variable

// If haven't login, then change to login page
if(!(isset($userid)))
{
	header("Location:Loginpage.php");
}

// an sql query to get the tutor ID
$getTutorID = mysqli_query($conn, 'SELECT tutors.`Lect ID` FROM tutors JOIN students ON students.`Tutor Id` = tutors.`Lect ID` WHERE students.`Student Id`= ' .$userid) or die('Error Fetching Tutor ID');
$tutorID = mysqli_fetch_array($getTutorID,MYSQLI_ASSOC); //fetching the tutor ID received from the query
//an sql query to get all students under the same tutor
$studentsUnderSameTutor = mysqli_query($conn, 'SELECT students.`Student Id`, students.`First Name`, students.`Last Name`, `academic plan codes`.`Academic Plan`, students.`Current Year` FROM `academic plan codes` JOIN students ON students.`Academic Plan Code` = `academic plan codes`.`Code` WHERE students.`Tutor Id` LIKE "'.$tutorID['Lect ID'].'"') or die("Error fetching students data.");

//sql query to get the tutor's name
$getTutorName = mysqli_query($conn, 'SELECT tutors.`Name` FROM tutors JOIN students ON students.`Tutor Id` = tutors.`Lect ID` WHERE students.`Student Id`= ' .$userid) or die('Error Fetching Tutor Name');
$tutorName = mysqli_fetch_array($getTutorName,MYSQLI_ASSOC); //fetching the tutor name received from the query

//sql query to get the tutor's school
$getTutorSchool = mysqli_query($conn, 'SELECT tutors.`School` FROM tutors JOIN students ON students.`Tutor Id` = tutors.`Lect ID` WHERE students.`Student Id`= ' .$userid) or die('Error Fetching Tutor Name');
$tutorSchool = mysqli_fetch_array($getTutorSchool,MYSQLI_ASSOC); //fetching the tutor's school received from the query

//sql query to get the tutor's email
$getTutorEmail = mysqli_query($conn, 'SELECT tutors.`email` FROM tutors JOIN students ON students.`Tutor Id` = tutors.`Lect ID` WHERE students.`Student Id`= ' .$userid) or die('Error Fetching Tutor Name');
$tutorEmail = mysqli_fetch_array($getTutorEmail,MYSQLI_ASSOC); //fetching the tutor's email received from the query

//sql query to get the tutor's office
$getTutorOffice = mysqli_query($conn, 'SELECT tutors.`office` FROM tutors JOIN students ON students.`Tutor Id` = tutors.`Lect ID` WHERE students.`Student Id`= ' .$userid) or die('Error Fetching Tutor Name');
$tutorOffice = mysqli_fetch_array($getTutorOffice,MYSQLI_ASSOC); //fetching the tutor's office received from the query

//end of PHP script
 ?>
<!-- start of the HTML script for the student view page  -->

 <!DOCTYPE html>
 <html>
  <head>
    <title> Students </title>
  </head>

  <body>
    <!-- Displaying the tutor's information received from the queries -->
    <p><strong>Tutor's Name: </strong> <?php echo $tutorName['Name'] ?> </br> <strong>Tutor's Email: </strong> <?php echo $tutorEmail['email'] ?> </br>
    <strong>Tutor's School: </strong> <?php echo $tutorSchool['School'] ?> </br> <strong>Tutor's Office: </strong> <?php echo $tutorOffice['office'] ?> </br></p>

<!--Displaying the list of students under the same tutor and their information -->
    <p> <strong> List of students under the same tutor: </strong> </p>
    <!-- Creating the table and its rows -->
    <table border="1">
      <tr>
        <td align="center"><strong>ID</strong></td>
        <td align="center"><strong>First Name</strong></td>
        <td align="center"><strong>Last Name</strong></td>
        <td align="center"><strong>Academic Plan</strong></td>
        <td align="center"><strong>Current Year</strong></td>
      </tr>
<!--Placing the student data into the rows of the table -->
      <?php
      $studentsList = $studentsUnderSameTutor;
      while ($rows = mysqli_fetch_array($studentsList,MYSQLI_ASSOC)) {
        ?>
        <tr>
          <?php
           echo '<td align="center">'.$rows['Student Id'].'</td>';
           echo '<td align="center">'.$rows['First Name'].'</td>';
           echo '<td align="center">'.$rows['Last Name'].'</td>';
           echo '<td align="center">'.$rows['Academic Plan'].'</td>';
           echo '<td align="center">'.$rows['Current Year'].'</td>';
          ?>
        </tr>
        <?php
      }
       ?>
     </table>

<!-- Hidden form that echoes (returns) the user id -->
     <form method="post" action="" id="studentlogin">
       <input type="hidden" name="LectID" value="<?php echo $userid; ?>" />
 		</form>

<!-- Log out button, when clicked it goes back to the login page -->
     <form method="post" action="Loginpage.php">
 			<input type="submit" value="Logout">
 		</form>

  </body>
  </html>
<!-- End of HTML script -->
