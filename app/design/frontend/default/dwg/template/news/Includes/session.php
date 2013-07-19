<?php

ini_set('display_errors',1);
error_reporting(E_ALL & ~ E_NOTICE);
	session_start();
	
	function logged_in() {
		return isset($_SESSION['user_id']);
	}
	
	function confirm_logged_in() {
		if (!logged_in()) {
			//redirect_to("login.php");
			return false;
		}
		return true;
	}
?>