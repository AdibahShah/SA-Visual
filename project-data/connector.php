<?php
	include 'config.php';
	/*
	*	Open connection to MYSQL database
	*/

		$con = mysqli_connect ($dbhost, $dbusername, $dbpassword) or die ('Error connecting: ' . mysqli_error($con));

		$db_selected = mysqli_select_db($con, $dbname);

		if(!$db_selected){
			$sql = 'CREATE DATABASE '.$dbname.'';
			if (mysqli_query($con, $sql)){
				echo "Database successfully created\n";
				$db_selected = mysqli_select_db($con, $dbname);
			} else {
				echo 'Error creating database: ' . mysqli_error() . "\n";
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

		$query2 = "SELECT `id` FROM " .$dbview;
		$result2 = mysqli_query($con, $query2);

		if (empty($result2)){
			echo $dbview." does not exist. Creating view now. \n";
			$query = mysqli_query($con, "CREATE VIEW `".$dbview."` AS SELECT id, `group`, MAX(CASE WHEN (type = 'time') THEN value ELSE NULL END) AS 'time', MAX(CASE WHEN (type = 'ip.src') THEN value ELSE NULL END) AS 'ip.src', MAX(CASE WHEN (type = 'ip.dst') THEN value ELSE NULL END) AS 'ip.dst', MAX(CASE WHEN (type = 'tcp.srcport') THEN value ELSE NULL END) AS 'tcp.srcport', MAX(CASE WHEN (type = 'tcp.dstport') THEN value ELSE NULL END) AS 'tcp.dstport', MAX(CASE WHEN (type = 'streams') THEN value ELSE NULL END) AS streams, MAX(CASE WHEN (type = 'country.dst') THEN value ELSE NULL END) AS 'country.dst', MAX(CASE WHEN (type = 'city.dst') THEN value ELSE NULL END) AS 'city.dst', MAX(CASE WHEN (type = 'latdec.dst') THEN value ELSE NULL END) AS 'latdec.dst', MAX(CASE WHEN (type = 'longdec.dst') THEN value ELSE NULL END) AS 'longdec.dst', MAX(CASE WHEN (type = 'org.dst') THEN value ELSE NULL END) AS 'org.dst', MAX(CASE WHEN (type = 'domain.dst') THEN value ELSE NULL END) AS 'domain.dst', MAX(CASE WHEN (type = 'country.src') THEN value ELSE NULL END) AS 'country.src', MAX(CASE WHEN (type = 'city.src') THEN value ELSE NULL END) AS 'city.src', MAX(CASE WHEN (type = 'latdec.src') THEN value ELSE NULL END) AS 'latdec.src', MAX(CASE WHEN (type = 'longdec.src') THEN value ELSE NULL END) AS 'longdec.src',MAX(CASE WHEN (type = 'service') THEN value ELSE NULL END) AS 'service', MAX(CASE WHEN (type = 'packets') THEN value ELSE NULL END) AS 'packets', MAX(CASE WHEN (type = 'alert.id') THEN value ELSE NULL END) AS 'alert.id', MAX(CASE WHEN (type = 'tcp.flags') THEN value ELSE NULL END) AS 'tcp.flags', MAX(CASE WHEN (type = 'ip.proto') THEN value ELSE NULL END) AS 'ip.proto', MAX(CASE WHEN (type = 'alias.host') THEN value ELSE NULL END) AS 'alias.host', MAX(CASE WHEN (type = 'alias.ip') THEN value ELSE NULL END) AS 'alias.ip', MAX(CASE WHEN (type = 'udp.srcport') THEN value ELSE NULL END) AS 'udp.srcport', MAX(CASE WHEN (type = 'org.src') THEN value ELSE NULL END) AS 'org.src', MAX(CASE WHEN (type = 'domain.src') THEN value ELSE NULL END) AS 'domain.src', MAX(CASE WHEN (type = 'email.src') THEN value ELSE NULL END) AS 'email.src', MAX(CASE WHEN (type = 'ip.srcport') THEN value ELSE NULL END) AS 'ip.srcport', MAX(CASE WHEN (type = 'user.src') THEN value ELSE NULL END) AS 'user.src', MAX(CASE WHEN (type = 'ad.domain.src') THEN value ELSE NULL END) AS 'ad.domain.src',MAX(CASE WHEN (type = 'ad.username.src') THEN value ELSE NULL END) AS 'ad.username.src', MAX(CASE WHEN (type = 'ad.computer.src') THEN value ELSE NULL END) AS 'ad.computer.src', MAX(CASE WHEN (type = 'udp.dstport') THEN value ELSE NULL END) AS 'udp.dstport', MAX(CASE WHEN (type = 'email.dst') THEN value ELSE NULL END) AS 'email.dst', MAX(CASE WHEN (type = 'ip.dstport') THEN value ELSE NULL END) AS 'ip.dstport', MAX(CASE WHEN (type = 'user.dst') THEN value ELSE NULL END) AS 'user.dst', MAX(CASE WHEN (type = 'ad.domain.dst') THEN value ELSE NULL END) AS 'ad.domain.dst', MAX(CASE WHEN (type = 'ad.username.dst') THEN value ELSE NULL END) AS 'ad.username.dst', MAX(CASE WHEN (type = 'ad.computer.dst') THEN value ELSE NULL END) AS 'ad.computer.dst', MAX(CASE WHEN (type = 'attachment') THEN value ELSE NULL END) AS 'attachment', MAX(CASE WHEN (type = 'alert') THEN value ELSE NULL END) AS 'alert' FROM ".$dbtable." GROUP BY `group` ORDER BY `group`");
		} else {
			echo $dbview." view exists \n";
		}
	
	/*
	*	Close connection
	*/
		mysqli_close($con);
?>
