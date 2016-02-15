<?php
	include 'config.php';

	/*
	*	Open connection to MYSQL database
	*/
	
		$con = mysqli_connect ($dbhost, $dbusername, $dbpassword) or die ('Error in connecting: ' . mysqli_error($con));

		$db_selected = mysqli_select_db($con, $dbname);

		if(!$db_selected){
			$sql = 'CREATE DATABASE '.$dbname.'';

			if (mysqli_query($con, $sql)){
				echo "Database successfully created\n";
			} else {
				echo 'Error creating database: ' . mysql_error() . "\n";
		  	}
		} else {
			echo $dbname." database exists \n";
		} 

		$query = "SELECT `id` FROM " .$dbtable;
		$result = mysqli_query($con, $query);

		if (empty($result)){
			echo $dbtable." table does not exist. Creating table now. \n";
			$query = mysqli_query($con, "CREATE TABLE IF NOT EXISTS " .$dbtable." (`id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, `group` INT(10) NOT NULL, `type` VARCHAR(100) NOT NULL, `value` VARCHAR(100) NOT NULL)");
		} else {
			echo $dbtable." table exists \n";
		}

		// Use prepare statement for insert query
		$st = mysqli_prepare($con, 'INSERT INTO `'.$dbtable.'` (`group`, `type`, `value`) VALUES (?,?,?)');

		// Bind the variables to insert query params
		mysqli_stmt_bind_param ($st, 'iss', $group, $type, $value);

	/*
	*	Passing Rest API Data to MYSQL
	*/

		// Method 1: Demo Data (Final Presentation Purpose)
		$filename = 'RestData.json';

		// Method 2: Data from RSA Security Analytic Concentrator / Broker
		//$filename = 'http://'.$SAUser.':'.$SAPass.'@'.$DevIP.':'.$DevPort.'/sdk?msg=query&query=where+time='.$DataWithinTime.'-u&force-content-type=application/json';

	/*
	*	Read contents of REST data from URL
	*/
				
		$json = file_get_contents($filename);

	/*
	*	Convert REST JSON data into associative array
	*/

		$resultobj = json_decode ($json, true);

		if(is_array($resultobj) || is_object($resultobj)){
			foreach ($resultobj as $obj){
				// Loop through the array
				foreach ($obj['results']['fields'] as $results){
					$group = $results['group'];
					$type = $results['type'];
					$value = $results['value'];

					mysqli_stmt_execute($st);
				}
			}
		}
		else{
			print "No data has been uploaded. \n";
		} 

	/*
	*	Close connection
	*/

		mysqli_close($con);
?>
