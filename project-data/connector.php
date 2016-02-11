<?php
	include 'config.php';

	/*
	*	Open connection to MYSQL database
	*/
	
		$con = mysqli_connect ($dbhost, $dbusername, $dbpassword, $dbname) or die ('Error in connecting: ' . mysqli_error($con));

		// Use prepare statement for insert query
		$st = mysqli_prepare($con, 'INSERT INTO `'.$dbtable.'` (`group`, `type`, `value`) VALUES (?,?,?)');

		// Bind the variables to insert query params
		mysqli_stmt_bind_param ($st, 'iss', $group, $type, $value);

	/*
	*	Passing Rest API Data to MYSQL
	*/

		// Method 1: Demo Data (Final Presentation Purpose)
		$filename = 'RestData.json';

		// Method 2: Data from RSA Security Analytics tool 
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
