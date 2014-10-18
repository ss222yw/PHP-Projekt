<?php
	

	session_start();

	require_once("../data/pathConfig.php");
	echo "<h1>NybroHH fastigheter</h1>";
	$navigationController = new NavigationController();

	// Run Application
    $navigationController->doControll();


    //Show time and date in swedish.
	setlocale(LC_ALL, 'swedish');
	$day = utf8_encode(ucfirst(strftime("%A")));
 	$date = ucwords(strftime($day .'en. Dsen %d %B år %Y. Klockan är [%X].'));
	echo $date;	

    			


