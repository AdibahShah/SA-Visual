# Security Analytic Cyber-Attack Visualization
Security Analytic (SA) Cyber-Attack Visualization is a prototype project for the RSA Security Analytic tool to provide users an <b>alternative view</b> to perform cyber-attack investigations for easier attack interpretations and analyzation, turning multiple rows of complex data into appealing visuals through the use of a <b>3D geographical data visualization</b>.

The prototype is currently <u>under development</u> in a <b>virtual machine</b>, running <b>Centos 6.5 OS with an Apache Web Server installed</b>. Therefore, it is not hosted on any websites. However, should you wish to view the prototype demo, please follow the steps listed under '<b>Prototype Demonstration</b>'.

### Visualization Library Used
  1. [Cesium](https://www.cesium.org) - Visualization Envrionment and Functions
  2. [Bing Maps](https://www.bingmapsportal.com/) - Basemap Provider

### Prototype Demonstration

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
  
  * You should be able to see the visualization environment - Globe, Timeline, Skybox. <b>NOTE: At this point, it does not contain any data </b>

#### Step 2: Upload data

  * [VM] Open terminal & change directory to /SA-Visual/project-data
  
  * Run the following command: <br>
  `./phpjobs.sh`




