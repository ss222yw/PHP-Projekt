<?php
	

	

	require_once("../data/pathConfig.php");
	$navigationController = new NavigationController();
	// Run Application
    $navigationController->doControll();
    

    //Show time and date in swedish.

	setlocale(LC_ALL, 'swedish');
	$day = utf8_encode(ucfirst(strftime("%A")));
 	$date = ucwords(strftime($day .'en. Den %d %B år %Y. Klockan är [%X].'));
	echo '<div class="navbar navbar-default"><div class="container-fluid">'.$date.'<br>&copy;Sahib Sahib ss222yw UD13<br> <a href="http://www.lnu.se/" target="_blank">LNU</a><br><a href="https://github.com/ss222yw/PHP-Projekt" target="_blank">Github</a></div></div>';	

    					



    			


