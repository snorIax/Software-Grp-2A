<?php
	include_once('Connection.php');
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="default.css">
	<title>Search</title>
</head>
<!-- Start Menu -->
	<div class="nav-btn">Menu</div>
	<div class="container">
		<div class="sidebar">

			<nav>
				<a href="#">Nottingham <span>Tutor System</span></a>
				<ul>
					<li><a href="tutorpage.php">Tutees</a></li>
					<li><a href="search.php">Search</a></li>
					<li><a href="loginpage.php">Log Out</a></li>
				</ul>

			</nav>
		</div>

	<!-- End Menu -->
	<div class="main-content">
			<b><h1>Search for a student</h1></b>
			<br>
			<!-- Start Panel -->
			<div class="panel-wrapper">
				<div class="panel-head">
			<!-- Start Table -->


<form action="" method="post">
	<input type="text" name="search" placeholder="Student ID or Name">
	<input style="height: 35px; width: 50px;" type="submit" value="Search">
</form>

<?php
if(isset($_POST['search'])) {
		$searchq = $_POST['search'];
		//Finds string or int close to what was searched
		$query = mysqli_query($conn,"SELECT * FROM `students` WHERE `Student Id` LIKE '%$searchq%' OR `First Name` LIKE '%$searchq%' OR `Last Name` LIKE '%$searchq%' OR `Full Name` LIKE '%$searchq%'") or die("could not search!");
		$count = mysqli_num_rows($query);
		if($count == 0) {
			$output = 'There were no search results!'; // This line doesnt work ?????
		} else {
			while($row = mysqli_fetch_array($query)) {
				$fname = $row['Full Name'];    //Retrieves students Full Name
				$id = $row['Student Id'];      //Retrieves Student id
				$email = $row['Email Address'];//Retrieves email

				echo '<br />' . $id .': '. $fname . ' - ' . $email . '<br />'; // Prints 'Student Id' : 'Full Name' - 'email'



			}
		}

	}
?>
				<!-- End Table -->
				</div>
			</div>
			<!-- End Panel -->
			</div>
</html>
