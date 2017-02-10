<?php
//get all the data form the db
require 'dbconnect.php';
$user_id =  $_POST["uid"];
//get the recent data from the table
$sql_query = "SELECT * FROM data where id like '$user_id' ORDER BY time_p DESC;";         
$result = mysqli_query($conn,$sql_query);  
 if(mysqli_num_rows($result) >0 )  
 {
 while($row = mysqli_fetch_assoc($result) )  {
 	$output [] = $row ; 
 }
 //get the json data
 echo json_encode($output);
 }  
 else  
 {   
 echo "Login Failed.......Try Again..";  
 }                      
?>