<?php
	include 'config.php';

	/*
	*	Connect to database
	*/

		$con = mysqli_connect ($dbhost, $dbusername, $dbpassword) or die ('Error in connecting: ' . mysqli_error($con));

	
		$db_selected = mysqli_select_db($con, $dbname);

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
