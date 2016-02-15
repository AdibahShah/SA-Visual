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
