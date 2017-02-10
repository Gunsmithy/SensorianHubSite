<?php
//check for the session time forlogin andexpire if the time is passed
function isLoginSessionExpired() {
	$login_session_duration = 10000; 
	$current_time = time(); 
	if(isset($_SESSION['loggedin_time']) and isset($_SESSION["userid"])){  
		if(((time() - $_SESSION['loggedin_time']) > $login_session_duration)){ 
			return true; 
		} 
	}
	return false;
}
?>