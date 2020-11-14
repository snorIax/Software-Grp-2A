<?php
	include('Connection.php');
	include('Import.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>
			File Submission
		</title>
	</head>
	<body>
		<form enctype="multipart/form-data" method="post" action="" id="importfile">
			<table border="1">
				<tr >
					<td colspan="2" align="center"><strong>Import CSV file</strong></td>
				</tr>
				<tr>
					<td align="center">CSV File:</td><td><input type="file" name="file" id="file"></td>
				</tr>
				<tr >
					<td colspan="2" align="center"><input type="submit" name="submitfile"></td>
				</tr>
			</table>
		</form>
		
		<form method="post" action="Loginpage.php">
			<input type="submit" value="Logout">
		</form>

	</body>
</html>



  