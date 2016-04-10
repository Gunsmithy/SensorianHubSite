<!--check for the db connection-->
<?php include 'dbconnect.php' ?>
<?php
//check for the post method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //get the json data from th pi
  $json_obj = file_get_contents("php://input");
  //decode the json data
  $arr = json_decode($json_obj,true);
  //parse the json data
  $hid= $arr["HW"];
  $ip = $arr["IP"];
  $cpu= $arr["CPU"];
  $lux = $arr["LUX"];
  $temp = $arr["Temp"];
  $press1= $arr["Press"];
  $ts= $arr["TS"];
  $x=$arr["X"];
  $y=$arr["Y"];
  $z=$arr["Z"];
  $press2= 100-(float)$press1;
  $press = sprintf("%.3f", $press2);
  //enter the data into the db
  //check if the data is valid bu checking thr hardware id for the user in user table
  // it will get the user id too
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
 //insert the data into table
 $insert_row = $conn->query("INSERT INTO data (id,time_p,ip,cpuTemp,lux,temp,press,acc_x,acc_y,acc_z) 
  VALUES ('$user_id', '$ts','$ip', '$cpu', '$lux', '$temp','$press','$x','$y','$z')");
 if($insert_row){
  echo "Value received and stored";
}else{
  echo "Error: " . $sql . "<br>" . $conn->error;
}$conn->close();


}
?> 