<?php include 'dbconnect.php' ?>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$user_id=10;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $json_obj = file_get_contents("php://input");
  $arr = json_decode($json_obj,true);

  $hid= $arr["HW"];
  $ip = $arr["IP"];
  $cpu= $arr["CPU"];
  $lux = $arr["LUX"];
  $temp = $arr["Temp"];
  $press= $arr["Press"];
  $ts= $arr["TS"];
  $x=$arr["X"];
  $y=$arr["Y"];
  $z=$arr["Z"];
  $sql= "SELECT id FROM users WHERE  hardwareId='$hid'";
  if($query_run = mysqli_query($conn, $sql))
  {
    $query_num_rows = mysqli_num_rows($query_run);
    $stmt =mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    echo "$query_num_rows";
    if($query_num_rows==1)
    {
     $row = mysqli_fetch_assoc($query_run);
     $user_id =  $row['id'];


   }
 }
 $insert_row = $conn->query("INSERT INTO data (id,temp_p,ip,cpuTemp,lux,temp,press,acc_x,acc_y,acc_z) 
  VALUES ('$user_id', '$ts','$ip', '$cpu', '$lux', '$temp','$press','$x','$y','$z')");
 if($insert_row){
  echo "Registration Successful...Welcome to App";
}else{
  echo "Please Try Again...";
}


}
?> 