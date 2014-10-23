<?php
	

	

	require_once("../data/pathConfig.php");
	$navigationController = new NavigationController();
	echo "<div class='navbar navbar-default'><div class='container-fluid'><h1>NybroHH fastigheter</h1></div></div>";
	// Run Application
    $navigationController->doControll();
    

    //Show time and date in swedish.

	setlocale(LC_ALL, 'swedish');
	$day = utf8_encode(ucfirst(strftime("%A")));
 	$date = ucwords(strftime($day .'en. Den %d %B år %Y. Klockan är [%X].'));
	echo '<div class="navbar navbar-default"><div class="container-fluid">'.$date.'<br>&copy;Sahib Sahib ss222yw UD13 <a href="http://www.lnu.se/" target="_blank">LNU</a></div></div>';	

    					



    			


