<?php
session_start();
unset($_SESSION["userid"]);
unset($_SESSION["name"]);
$url = "loginPage.php";
if(isset($_GET["session_expired"])) {
	$url .= "?session_expired=" . $_GET["session_expired"];
}
header("Location:$url");
?>