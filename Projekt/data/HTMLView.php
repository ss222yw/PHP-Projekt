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
								<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
								<link rel="apple-touch-icon-precomposed" href="apple-touch-icon-57x57.png" />
								<link rel="apple-touch-icon-precomposed" sizes="72x72" href="apple-touch-icon-72x72.png" />
								<link rel="apple-touch-icon-precomposed" sizes="114x114" href="apple-touch-icon-114x114.png" />
								<link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch-icon-144x144.png" />
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
