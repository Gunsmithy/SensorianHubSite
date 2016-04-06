<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'dbconnect.php';
$user_id =  $_POST["uid"];
$sql_query = "SELECT * FROM data where id like '$user_id' ORDER BY time_p DESC LIMIT 1;";         
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