<?php
	

	session_start();
	echo "<h1>NybroHH fastigheter</h1>";
	// Initialize security objects to identify hijacking.
	$remote_ip = $_SERVER['REMOTE_ADDR'];
	// $b_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$user_agent = $_SERVER['HTTP_USER_AGENT'];

	if (!isset($_SESSION['LoginValues'])) {
		
		$_SESSION['LoginValues']['username'] = '';
	}

	require_once("../data/pathConfig.php");

	$navigationController = new NavigationController();

	// Run Application
    $navigationController->doControll();

    //Show time and date in swedish.
	setlocale(LC_ALL, 'swedish');
	$day = utf8_encode(ucfirst(strftime("%A")));
 	$date = ucwords(strftime($day .'en. Den %d %B år %Y. Klockan är [%X].'));
	echo $date;	

    			


