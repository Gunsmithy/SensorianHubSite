# SensorianHubSite
Website to receive, store, and view data gathered from Sensorian Shield devices  
Course project for SOFE 4870U - Special Topics: Cloud Computing 2016  

Code originally written by my partner, from whom I've taken on the task of maintaining it  
Currently written in PHP and MySQL, with plans to support other server platforms in the future  
The site is very rudimentary, but demonstrates how the [Sensorian Hub Client](https://github.com/sensorian/SensorianHubClient) can easily integrate with other web services.  
To deploy:  
1. Setup a basic LAMP stack on a server of your choosing  
2. Add the website files to a directory in the Apache html directory, typically `/var/www/`  
2. Login to your mysql server using `mysql --user=USER --password=PASSWORD`  
3. Create a new database with the name of your choice using `CREATE DATABASE DATABASE_NAME;` and `exit;`  
4a. Import the two SQL dumps to that database to create the necessary tables:  
4b. `mysql --user=USER --password=PASSWORD DATABASE_NAME < users_dump.sql`  
4c. `mysql --user=USER --password=PASSWORD DATABASE_NAME < data_dump.sql`  
5. Modify the `dbconnect-example.php` with your MySQL credentials and save as `dbconnect.php`  
6. Browse to `http://your_server_address/FOLDER_NAME/register.php` to create a login and begin!  
6b. The Hardware Id on this page is referring the the CPU serial of your Raspberry Pi.  

Attached below are Saurabh's additions to the readme file  

1) Register to the website with the proper hardware id.  
2) Hardware id can be found on the LCD display of the Sensorian.  
3) Currently user can only have one connect one Sensorian to the website.  
4) If this is first time connecting to the website please first connect the Sensorian and start sending data to the website otherwise you will get the following error "No data in the Database. Please connect to Raspberry Pi."  
5) After login in with the proper credentials wait for 5s for the result to be displayed and 5s for the graph.  
6) Since in Sensorian you are only allowed to either measure the altitude or pressure, for this project for default we have set up the Sensorian for pressure so the table will show null for the display all result, current result and Altitude.  
7) User can easily change the setting to altitude on the Sensorian and the data will be visible on the website without any change in the settings  


Future Development:  
1) Giving user the option to connect many Sensorian to the website under one username  


Website detail:  
Website mostly uses the ajax, jQuery and scripts to get the data from the database. Website constantly checks for the "POST" request from the Sensorian. Once the "POST" request is met on the "inputData.php" it will check for the user hardware id and once it is found in database the data is inserted in the table.  
When the user logs into the website with the proper credential the data is shown in the table and the real time graph display. Users have the option to select from current data and all result. By default when user login the website he/she will taken to all result tab. We also parse the data for the CPU temp, temp and various other and display it under the assigned tab.  
We use ajax, jQuery and script to display the table for the user. We check for the new data in the database every 5s and display it.  
For the real time graph we use the smoothie chart for the display. We check database every 5s for the new data. Graph have initial 10s delay to give it smooth effect to the graph.  
 