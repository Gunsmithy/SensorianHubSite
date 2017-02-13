<?php
//session started
//logot for the website
session_start();
unset($_SESSION["userid"]);
unset($_SESSION["name"]);
$url = "index.php";
if(isset($_GET["session_expired"])) {
	$url .= "?session_expired=" . $_GET["session_expired"];
}
header("Location:$url");
?>