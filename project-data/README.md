| Files           | Description                                                   |
| --------------- | -------------                                                 |
| RestData.json   | A sample data (demo) to visualize the alerts                  |

| Files           | Description |
| --------------  | ----------- |
| config.php      | Holds all of the variables used in majority of the files to do the following<br> 1. Connect to MySQL database <br>  2. Connect to RSA Security Analytic concentrator / broker <br> 3. Connect to RSA Security Analytic Server <br> 4. Set time for page refresh    |
| connector.php   | 1. Retrieves data from RSA Security Analytic Concentrator or Broker <br> 2. Converts JSON data into PHP associative array <br> 3. Stores it into MySQL database. <br> Some variables found in this file can be edited in config.php |
| pass.php        | 1. Retrieves data from the view created <br> 2. Converts it back to JSON <br> Some variables found in this file can be edited in config.php |
| delete.php      | Deletes all data in the MySQL database. <br> Some variables found in this file can be edited in config.php |
| phpjobs.sh      | Combines and runs delete.php, connector.php and pass.php in sequence. <br> You can configure crontab to schedule it and constantly retrieve data from the concentrator or broker. <br> However, if you are using RestData.json, you will not need this to be activated |

## Prototype: Demo Data

#### Step 1: Upload demo data

  * [VM] Open terminal & change directory to /SA-Visual/project-data
  
  * Run the following command: <br>
  `gedit config.php`

As you are about to upload a demo data, you will only have to configure the following:<br>

  `	// Variables to connect to MySQL Database` <br>
  
* Login Credentials to MySQL Database <br>
```php
$dbhost = "localhost";
$dbusername = "root";
$dbpassword = "password";
```

* Database, Table, View Names <br>
You <b>do not</b> have to manually create database, table and view via phpmyadmin's web console.<br>
./phpjobs.sh will do that for you. <br>
```php
$dbname = "restapi";
$dbtable = "attackdata";
$dbview = "RestView";
```

* Next, run the following command: <br>
  `./phpjobs.sh` <br>

    The database, table & view containing the data will be created.

##### Test

  To check if data has been successfully uploaded into MySQL database, do either of the following:
  
  * [Host] Open a web browser and enter the url as such:<br>
  `<ip-addressOfVM>/project-data/pass.php` <br>

    The page above should contain a JSON data.
  
  OR

  * [Host] Open a web browser and enter the url as such: <br>
  `<ip-addressOfVM>/phpmyadmin` <br>

    Search for the database & ensure that both <b>table</b> & <b>view</b> has been created.

#### Step 2: View Visualization

Once the demo data has been successfully uploaded into the database, you are able to visualize it. To do so, simply proceed to the page with the following url: <br>
  `<ip-addressOfVM>` <br>
  
  And click onto 'View Visualization' button

## Prototype: RSA Security Analytic Concentrator/Broker Data

<b>NOTE:</b> It is a <b>requirement</b> for the data from the concentrator / broker to <b>contain the coordinates of the source (latdec.src, longdec.src) AND destination countries (latdec.dst, longdec.dst)</b>. Otherwise, the alert will be <b>omitted</b> from the visualization.

#### Step 1: Edit config.php

  * [VM] Open terminal & change directory to /SA-Visual/project-data
  
  * Run the following command: <br>
  `gedit config.php`

The following lines are <b>required</b> variables to connect to MySQL database. Configure it according to your MySQL settings.<br>

`// Variables to connect to MySQL Database` <br>
  
* Login Credentials to MySQL Database <br>
```php
$dbhost	= "localhost";
$dbusername = "root";
$dbpassword = "password";
```

* Database, Table, View Names <br>
You <b>do not</b> have to manually create database, table and view via phpmyadmin's web console.<br>
./phpjobs.sh will do that for you. <br>
```php
$dbname	= "restapi";
$dbtable = "attackdata";
$dbview = "RestView";
```

The following lines are <b>required</b> variables to connect to RSA Security Analytic Concentrator/Broker. <br>

`// Configurable variables to connect to RSA Security Analytics Concentrator / Broker` <br>

* Login Credentials to RSA Security Analytic Server <br>
```php
$SAUser = “admin”;
$SAPass = “netwitness”;
```

* Concentrator / Broker IP Address <br>
```php
$DevIP	= '10.63.215.23';
```

* Concentrator / Broker Port <br>
```php
$DevPort = '50105';
```

`// Configurable variables to control how much data you wish to retrieved` <br>

* Retrieve data from 30 mins ago & sets the time to refresh the visualization <br>
```php
$TimeRange = '1800';
```

`// Configurable variables to connect to RSA Security Analytics Server` <br>

* RSA Security Analytic IP Address <br>
```php
	`$SAIP	= '10.63.215.25';`
```

* Concentrator / Broker ID <br>
```php
	$DevID	= '8';
```

`// Configurable variables to reload page`

* Adds buffer between retrieval of data & page reload
* Recommended. Retrieving of data can take a few minutes to complete <br>
```php
$addMinutes = '300';`<br>
$reloadTime = $TimeRange + $addMinutes;
```

#### Step 2: Edit connector.php

  * [VM] Open terminal & change directory to /SA-Visual/project-data
  
  * Run the following command: <br>
  `gedit connector.php`

<b>DISABLE Method 1</b> and <b>ENABLE Method 2</b>. Refer below:

```php
/*
Method 1: Demo Data (Final Presentation Purpose)
$filename = 'RestData.json';

Method 2: Data from RSA Security Analytics Concentrator / Broker
*/

$filename = 'http://'.$SAUser.':'.$SAPass.'@'.$DevIP.':'.$DevPort.'/sdk?msg=query&query=where+time='.$DataWithinTime.'-u&force-content-type=application/json';
```

#### Step 3: Run ./phpjobs.sh

  * [VM] Open terminal & change directory to /SA-Visual/project-data
  
  * Run the following command: <br>
  `./phpjobs.sh`

##### Test

  To check if data has been successfully uploaded into MySQL database, do either of the following:
  
  * [Host] Open a web browser and enter the url as such:<br>
  `<ip-addressOfVM>/project-data/pass.php` <br>

    The page above should contain a JSON data.
  
  OR

  * [Host] Open a web browser and enter the url as such: <br>
  `<ip-addressOfVM>/phpmyadmin` <br>

    Search for the database & ensure that both <b>table</b> & <b>view</b> has been created.
    
#### Step 4: Edit IntelCyberOcular.html

  * [VM] Open terminal & change directory to /SA-Visual/Cesium/Apps
  
  * Run the following command: <br>
  `gedit IntelCyberOcular.html`

<b>DISABLE 'Demo Timeline Settings'</b> and <b>ENABLE 'Your Timeline Settings'</b>. Refer below:

```Javascript
/* 
	DEMO TIMELINE SETTINGS 
	THIS IS A SETTING FOR THE DEMO DATA - RestData.json
	To enable it, simply remove the '/*' & '* /' from the codes below and add them to the codes under YOUR TIMELINE SETTINGS

	viewer.clock.startTime = Cesium.JulianDate.fromIso8601("2014-08-29T19:29:00Z");  
	viewer.clock.currentTime =Cesium.JulianDate.fromIso8601("2014-08-29T19:29:00Z");  
	viewer.clock.multiplier = 2;
	viewer.timeline.zoomTo(start, stop);
				
	YOUR TIMELINE SETTINGS
	APPLICABLE IF YOU ARE USING YOUR OWN DATA
	To enable it, simply remove the '/*' & '* /' from the codes below and add them to the codes under DEMO TIMELINE SETTINGS
*/

	viewer.clock.startTime = Cesium.JulianDate.fromIso8601(DataWithinTimeISO);  
	viewer.clock.currentTime =Cesium.JulianDate.fromIso8601(DataWithinTimeISO);  
	viewer.clock.multiplier = 2;
	viewer.timeline.zoomTo(start, stop);
```

#### Step 5: View Visualization

After setting up the configurations, you should be able to view the visualization with data from your own RSA Security Analytic's Concentrator/Broker<br>

* [Host] Open up a web browser and enter the following URL: <br>
  `<ip-addressOfVM>` <br>
  
  And click onto 'View Visualization' button
