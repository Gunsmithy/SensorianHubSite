<?php
//get recent 1 data from the db
require 'dbconnect.php';
$user_id =  $_POST["uid"];
$sql_query = "SELECT cpuTemp,time_p FROM data where id like '$user_id'ORDER BY time_p DESC;";         
$result = mysqli_query($conn,$sql_query);  
 
 if(mysqli_num_rows($result) >0 )  
 {
 while($row = mysqli_fetch_assoc($result) )  {
 	$output [] = $row ; 
 }
 echo json_encode($output);
 }  
 else  
 {   
 echo "Login Failed.......Try Again..";  
 }                      
?>