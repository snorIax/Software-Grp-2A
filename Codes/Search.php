<?php	
	include_once('Connection.php'); 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
</head>
<body>
	<h1>Search for a student</h1>



<form action="" method="post">
	<input type="text" name="search" placeholder="Student ID or Name">
	<input type="submit" value="Search">
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
</body>
</html>