<?php
	include 'config.php';

	/*
	*	Connect to database
	*/

		$con = mysqli_connect ($dbhost, $dbusername, $dbpassword) or die ('Error in connecting: ' . mysqli_error($con));

	
		$db_selected = mysqli_select_db($con, $dbname);

	/*
	*	Create View
	*/
	
		$createView = mysqli_query($con, "CREATE VIEW `".$dbview."` AS SELECT id, `group`, MAX(CASE WHEN (type = 'time') THEN value ELSE NULL END) AS 'time', MAX(CASE WHEN (type = 'ip.src') THEN value ELSE NULL END) AS 'ip.src', MAX(CASE WHEN (type = 'ip.dst') THEN value ELSE NULL END) AS 'ip.dst', MAX(CASE WHEN (type = 'tcp.srcport') THEN value ELSE NULL END) AS 'tcp.srcport', MAX(CASE WHEN (type = 'tcp.dstport') THEN value ELSE NULL END) AS 'tcp.dstport', MAX(CASE WHEN (type = 'streams') THEN value ELSE NULL END) AS streams, MAX(CASE WHEN (type = 'country.dst') THEN value ELSE NULL END) AS 'country.dst', MAX(CASE WHEN (type = 'city.dst') THEN value ELSE NULL END) AS 'city.dst', MAX(CASE WHEN (type = 'latdec.dst') THEN value ELSE NULL END) AS 'latdec.dst', MAX(CASE WHEN (type = 'longdec.dst') THEN value ELSE NULL END) AS 'longdec.dst', MAX(CASE WHEN (type = 'org.dst') THEN value ELSE NULL END) AS 'org.dst', MAX(CASE WHEN (type = 'domain.dst') THEN value ELSE NULL END) AS 'domain.dst', MAX(CASE WHEN (type = 'country.src') THEN value ELSE NULL END) AS 'country.src', MAX(CASE WHEN (type = 'city.src') THEN value ELSE NULL END) AS 'city.src', MAX(CASE WHEN (type = 'latdec.src') THEN value ELSE NULL END) AS 'latdec.src', MAX(CASE WHEN (type = 'longdec.src') THEN value ELSE NULL END) AS 'longdec.src',MAX(CASE WHEN (type = 'service') THEN value ELSE NULL END) AS 'service', MAX(CASE WHEN (type = 'packets') THEN value ELSE NULL END) AS 'packets', MAX(CASE WHEN (type = 'alert.id') THEN value ELSE NULL END) AS 'alert.id', MAX(CASE WHEN (type = 'tcp.flags') THEN value ELSE NULL END) AS 'tcp.flags', MAX(CASE WHEN (type = 'ip.proto') THEN value ELSE NULL END) AS 'ip.proto', MAX(CASE WHEN (type = 'alias.host') THEN value ELSE NULL END) AS 'alias.host', MAX(CASE WHEN (type = 'alias.ip') THEN value ELSE NULL END) AS 'alias.ip', MAX(CASE WHEN (type = 'udp.srcport') THEN value ELSE NULL END) AS 'udp.srcport', MAX(CASE WHEN (type = 'org.src') THEN value ELSE NULL END) AS 'org.src', MAX(CASE WHEN (type = 'domain.src') THEN value ELSE NULL END) AS 'domain.src', MAX(CASE WHEN (type = 'email.src') THEN value ELSE NULL END) AS 'email.src', MAX(CASE WHEN (type = 'ip.srcport') THEN value ELSE NULL END) AS 'ip.srcport', MAX(CASE WHEN (type = 'user.src') THEN value ELSE NULL END) AS 'user.src', MAX(CASE WHEN (type = 'ad.domain.src') THEN value ELSE NULL END) AS 'ad.domain.src',MAX(CASE WHEN (type = 'ad.username.src') THEN value ELSE NULL END) AS 'ad.username.src', MAX(CASE WHEN (type = 'ad.computer.src') THEN value ELSE NULL END) AS 'ad.computer.src', MAX(CASE WHEN (type = 'udp.dstport') THEN value ELSE NULL END) AS 'udp.dstport', MAX(CASE WHEN (type = 'email.dst') THEN value ELSE NULL END) AS 'email.dst', MAX(CASE WHEN (type = 'ip.dstport') THEN value ELSE NULL END) AS 'ip.dstport', MAX(CASE WHEN (type = 'user.dst') THEN value ELSE NULL END) AS 'user.dst', MAX(CASE WHEN (type = 'ad.domain.dst') THEN value ELSE NULL END) AS 'ad.domain.dst', MAX(CASE WHEN (type = 'ad.username.dst') THEN value ELSE NULL END) AS 'ad.username.dst', MAX(CASE WHEN (type = 'ad.computer.dst') THEN value ELSE NULL END) AS 'ad.computer.dst', MAX(CASE WHEN (type = 'attachment') THEN value ELSE NULL END) AS 'attachment', MAX(CASE WHEN (type = 'alert') THEN value ELSE NULL END) AS 'alert' FROM ".$dbtable." GROUP BY `group` ORDER BY `group`") or die ("Error with creating view: ".mysqli_error($con));

		$result = mysqli_query($con, 'select * from `'.$dbview.'` WHERE (`latdec.src` is not null and `longdec.src` is not null) AND (`latdec.dst` is not null and `longdec.dst` is not null)') or die ("Error with select query: ".mysqli_error($con));

	/*
	*	Convert data from MYSQL back to JSON array
	*/

		$json_response = array();

		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

			/* Uncategorized */
			$row_array['id'] = $row['id'];
			$row_array['group'] = $row['group'];
			$row_array['service'] = $row['service'];
			$row_array['packets'] = $row['packets'];
			$row_array['alert.id']=$row['alert.id'];
			$row_array['alert'] = $row['alert'];
			$row_array['time'] = $row['time'];
			$row_array['tcp.flags'] = $row['tcp.flags'];
			$row_array['ip.proto'] = $row['ip.proto'];
			$row_array['alias.ip'] = $row['alias.ip'];
			$row_array['alias.host'] = $row['alias.host'];
			$row_array['attachment'] = $row['attachment'];
			$row_array['streams'] = $row['streams'];			

			/* Source */
			$row_array['ip.src'] = $row['ip.src'];
			$row_array['country.src'] = $row['country.src'];
			$row_array['city.src'] = $row['city.src'];
			$row_array['latdec.src'] = $row['latdec.src'];
			$row_array['longdec.src'] = $row['longdec.src'];
			$row_array['tcp.srcport'] = $row['tcp.srcport'];
			$row_array['udp.srcport'] = $row['udp.srcport'];
			$row_array['org.src'] = $row['org.src'];
			$row_array['domain.src'] = $row['domain.src'];
			$row_array['email.src'] = $row['email.src'];
			$row_array['ip.srcport'] = $row['ip.srcport'];
			$row_array['user.src'] = $row['user.src'];
			$row_array['ad.domain.src'] = $row['ad.domain.src'];
			$row_array['ad.username.src'] = $row['ad.username.src'];
			$row_array['ad.computer.src'] = $row['ad.computer.src'];

			/* Destination */
			$row_array['ip.dst'] = $row['ip.dst'];
			$row_array['tcp.dstport'] = $row['tcp.dstport'];
			$row_array['udp.dstport'] = $row['udp.dstport'];
			$row_array['country.dst'] = $row['country.dst'];
			$row_array['city.dst'] = $row['city.dst'];
			$row_array['latdec.dst'] = $row['latdec.dst'];
			$row_array['longdec.dst'] = $row['longdec.dst'];
			$row_array['org.dst'] = $row['org.dst'];
			$row_array['domain.dst'] = $row['domain.dst'];
			$row_array['email.dst'] = $row['email.dst'];
			$row_array['ip.dstport'] = $row['ip.dstport'];
			$row_array['user.dst'] = $row['user.dst'];
			$row_array['ad.domain.dst'] = $row['ad.domain.dst'];
			$row_array['ad.username.dst'] = $row['ad.username.dst'];
			$row_array['ad.computer.dst'] = $row['ad.computer.dst'];

			array_push($json_response, $row_array);
		}
	
		echo json_encode($json_response);

	/*
	*	Close connection
	*/

		mysqli_close($con);
?>
