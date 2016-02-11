<?php
	// Variables to connect to MySQL Database
	$dbhost 	= "localhost";
	$dbusername 	= "root";
	$dbpassword 	= "password";
	$dbname 	= "restapi";
	$dbtable	= "attackdata";
	$dbview 	= "RestView";

	// [Configurable] Variables to connect to RSA Security Analytics Concentrator / Broker
	$SAUser 	= "admin";
	$SAPass 	= "netwitness";
	$DevIP 		= '10.63.215.23';
	$DevPort 	= '50105'; 

	// [Not Configurable] Please do not touch.
	$TimeCurrent 	= time();
	$TimeISO8601 	= gmdate('Y-m-d\TH:i:s\Z', $TimeCurrent); 

	// [Configurable] Variables to control how much data you want to receive (e.g. retrieve data from 30 mins ago)
	$TimeRange	= '1800';	// 30 minutes

	// [Not Configurable] Please do not touch
	$DataWithinTime = ($TimeCurrent - $TimeRange); // Gets data from 30 minutes ago
	$DataWithinTimeISO = gmdate('Y-m-d\TH:i:s\Z', $DataWithinTime);

	// [Configurable] Variables to connect to RSA Security Analytics Server
	$SAIP 		= '10.63.215.25';
	$DevID 		= '8';

	// [Configurable] Variables to reload page
	$addMinutes = 300;
	$reloadTime = $TimeRange + $addMinutes;
?>
