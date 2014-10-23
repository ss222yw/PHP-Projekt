<?php
	
	class emailService {

		private static $to = "ss222yw@student.lnu.se";
		private static $subj = "Felanmälan";
		private static $succesMessageMail = "<p class='bg-success'>Ditt felanmäla har skickat. Hör av oss. Tack!</p><br><br>";


		public function __construct() {

		}
		// Mail function to send a message by service from
		public function EmailService($messages,$headers) {

			if (mail(self::$to, self::$subj, $messages, $headers)) {

				echo self::$succesMessageMail; 
			}
		
		
		}

	}