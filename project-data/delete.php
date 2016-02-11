<?php
	include 'config.php';

	$conn = mysql_connect($dbhost, $dbusername, $dbpassword);

	if(! $conn )
	{
	  die('Could not connect: ' . mysql_error());
	}

	$sql = 'DELETE FROM `'.$dbtable.'`
	        WHERE 1';

	mysql_select_db($dbname);

	$retval = mysql_query( $sql, $conn );
	
	if(! $retval )
	{
	  die('Could not delete data: ' . mysql_error());
	}
	
	echo "Deleted data successfully\n";
	
	mysql_close($conn);
?>
