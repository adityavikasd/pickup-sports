<?php
	session_start();
	unset($_SESSION['user']);
	unset($_SESSION['userID']);
	header("Location: /PickUpSports/home.php");
?>
