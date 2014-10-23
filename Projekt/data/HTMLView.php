<?php
	
	class HTMLView {

		function echoHTML ($body){
			if ($body === null) {
				throw new \Exception("HTMLView->HTMLView does not allow body to be null");
			}

				echo 
					'<!DOCTYPE HTML>
						<html>
							<head>
								<meta content="text/html; charset=utf-8" http-equiv="content-type">
								<meta name="viewport" content="width=device-width, initial-scale=1">
								<title>NybroHH fastigheter</title>
								<link rel="stylesheet" href="../data/css/bootstrap.min.css">
								<link rel="stylesheet" href="../data/css/bootstrap-theme.min.css">
							</head>
							<body>'.
							'<div class="navbar navbar-default">'.
							'<div class="container-fluid">'.
								$body .
								 '</div>'.
								'</div>'.
								'<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>'.
							'</body>
						</html>';
		}
	}
