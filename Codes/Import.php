<?php

	if(isset($_POST['submitfile']))
	{

		include_once('Connection.php');
		
		if(mysqli_connect_error())
		{
			die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
		}
		else
		{
			$filename = $_SERVER['DOCUMENT_ROOT']."/".$_FILES["file"]["name"];
			$ext = substr($filename,strrpos($filename,"."),(strlen($filename)-strrpos($filename,".")));
			if($ext==".csv")
			{
				mysqli_query($conn, 'TRUNCATE TABLE temp') or die("Truncate error");
				move_uploaded_file($_FILES["file"]["tmp_name"],$filename);
				$file = fopen($filename, "r");
				fgetcsv($file);
				while (($datacol = fgetcsv($file)) !== FALSE)
				{
					if ($datacol[16] != "Yes")
					{
						continue;
					}
					for ($i = 0; $i < 19; $i++)
					{
						$datacol[$i] = Addslashes($datacol[$i]);
						if (empty($datacol[$i]))
						{
							$datacol[$i] = Null;
						}
						elseif ($datacol[$i] == "NA")
						{
							$datacol[$i] = "Null";
						}
					}
					$sql = "INSERT into temp(`Student ID`,`Full Name`,`First Name`,`Last Name`,`Nationality`,`Gender`,`Academic Plan Code`,`Intake`,`Year of Entry (UG)`,`Fnd 2-sem or 3-sem?`,`New / Progressing`,`Level`,`Email Address`,`Registration Date`,`Registered`,`Remarks`,`Remarks 2`) values($datacol[0],'$datacol[1]','$datacol[2]','$datacol[3]','$datacol[4]','$datacol[5]','$datacol[6]','$datacol[8]',$datacol[9],'$datacol[10]','$datacol[11]','$datacol[13]','$datacol[14]','$datacol[15]','$datacol[16]','$datacol[17]','$datacol[18]')";
					mysqli_query($conn, $sql) or die("Import error");
					//die(mysqli_error($conn)."\n".$sql); - to check if sql error
				}
				fclose($file);
				include('SortNew.php');
				echo '<script>window.confirm("CSV File has been successfully Imported and tutees have been assigned.");</script>';
			}
			else
			{
				echo '<script>window.confirm("Error: Please Upload only CSV File");</script>';
			}
		}
	}
	
?>