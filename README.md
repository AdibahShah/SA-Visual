# Security Analytic Cyber-Attack Visualization
Security Analytic (SA) Cyber-Attack Visualization is a prototype project for the RSA Security Analytic tool to provide users an <b>alternative view</b> to perform cyber-attack investigations for easier attack interpretations and analyzation, turning multiple rows of complex data into appealing visuals through the use of a <b>3D geographical data visualization</b>.

The prototype is currently <u>under development</u> in a <b>virtual machine</b>, running <b>Centos 6.5 OS with an Apache Web Server installed</b>. Therefore, it is not hosted on any websites. However, should you wish to view the prototype demo, please follow the steps listed under '<b>Prototype Demonstration</b>'.

### Visualization Library Used
  1. [Cesium](https://www.cesium.org) - Visualization Envrionment and Functions
  2. [Bing Maps](https://www.bingmapsportal.com/) - Basemap Provider

### Prototype: Demo Data

#### Step 1: Set up Virtual Machine

  * [Download](http://isoredirect.centos.org/centos/7/isos/x86_64/CentOS-7-x86_64-DVD-1511.iso) the latest version of Centos ISO 
  
  * With a VMware Workstation installed, create a VM with the Centos ISO dvd.
  
  * As Internet connection is required, please ensure that the network is set to <b>Bridged </b>
  
  * Install LAMP (Linux 4.4.15.1, Apache 2.2.15, MySQL 5.5.46 & PHP 5.4.45) in the VM. 
  
  * [Host] Clone the repository from github with the following command: <br>
  `git clone https://github.com/AdibahShah/SA-Visual.git`

  * [Host] Transfer the SA-Visual folder into the VM.

  * Append the following line in <b>/etc/httpd/conf/httpd.conf</b>: <br>
  `AddType application/x-httpd-php .html .htm`

  * Ensure that the root directory is pointing to <b>SA-Visual</b> folder

##### Test

  * [VM] Open terminal & enter the following command to retrieve the IP Address: <br>
  `ifconfig`

  * [Host] Open a web browser and enter the IP Address retrieved from above
  
  * You should be able to see the visualization environment - Globe, Timeline, Skybox. <br><b>NOTE: At this point, it does not contain any data </b>

#### Step 2: Upload demo data

  * [VM] Open terminal & change directory to /SA-Visual/project-data
  
  * Run the following command: <br>
  `gedit config.php`

As you are about to upload a demo data, you will only have to configure the following:<br>
  `	// Variables to connect to MySQL Database` <br>
	`$dbhost 	= "localhost";`<br>
	`$dbusername 	= "root";`<br>
	`$dbpassword 	= "password";`<br>
	`$dbname 	= "restapi";`<br>
	`$dbtable	= "attackdata";`<br>
	`$dbview 	= "RestView";`

  * Next, run the following command: <br>
  `./phpjobs.sh` <br>

    The database, table & view containing the data will be uploaded.

##### Test

  To check if data has been successfully uploaded into MySQL database, do either of the following:
  
  * [Host] Open a web browser and enter the url as such:<br>
  `<ip-addressOfVM>/project-data/pass.php` <br>

    The page above should contain a JSON data.
  
  OR

  * [Host] Open a web browser and enter the url as such: <br>
  `<ip-addressOfVM>/phpmyadmin` <br>

    Search for the database & ensure that both <b>table</b> & <b>view</b> has been created.

#### Step 3: View Visualization

Once the demo data has been successfully uploaded into the database, you are able to visualize it. To do so, simply proceed to the page with the following url: <br>
  `<ip-addressOfVM>` <br>
  
  And click onto 'View Visualization' button

### Prototype: RSA Security Analytic Concentrator/Broker Data

<b>NOTE:</b> It is a <b>requirement</b> for the data from the concentrator / broker to <b>contain the coordinates of the source (latdec.src, longdec.src) and destination countries (latdec.dst, longdec.dst)</b>. Otherwise, the alert will be <b>omitted</b> from the visualization.

#### Step 1: Set up Virtual Machine

Refer to Step 1 under 'Prototype: Demo Data'.

#### Step 2: Edit config.php

  * [VM] Open terminal & change directory to /SA-Visual/project-data
  
  * Run the following command: <br>
  `gedit config.php`

The following lines are <b>required</b> variables to connect to MySQL database. Configure it according to your MySQL settings.<br>

  `	// Variables to connect to MySQL Database` <br>
  
* Login Credentials to MySQL Database <br>
	`$dbhost 	= "localhost";`<br>
	`$dbusername 	= "root";`<br>
	`$dbpassword 	= "password";`<br>

* Database, Table, View Names <br>
	`$dbname 	= "restapi";`<br>
	`$dbtable	= "attackdata";`<br>
	`$dbview 	= "RestView";` <br>

The following lines are <b>required</b> variables to connect to RSA Security Analytic Concentrator/Broker. <br>

* Login Credentials to RSA Security Analytic Server <br>
	`$SAUser		=	“admin”;` <br>
	`$SAPass		=	“netwitness”;` <br>

* Concentrator / Broker IP Address <br>
	`$DevIP		=	'10.63.215.23';`<br>

* Concentrator / Broker Port <br>
	`$DevPort		=	'50105';` <br>

// Configurable variables to control how much data you wish to retrieved
$TimeRange	=	'1800';

// Configurable variables to connect to RSA Security Analytics Server
$SAIP		=	'10.63.215.25';

$DevID		=	'8';

// Configurable variables to reload page
$addMinutes = '300';
$reloadTime = $TimeRange + $addMinutes;
