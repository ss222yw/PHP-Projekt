<?php
	
	class emailService {

		private static $to = "ss222yw@student.lnu.se";
		private static $subj = "Felanmälan";
		private static $succesMessageMail = '<div class="alert alert-success alert-dismissible" role="alert">
  							 				 <button type="button" class="close" data-dismiss="alert">
  											 <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										     <strong>Ditt felanmäla har skickat. Hör av oss. Tack!</strong></div>';

		public function __construct() {

		}
		// Mail function to send a message by service from
		public function EmailService($messages,$headers) {

			if (mail(self::$to, self::$subj, $messages, $headers)) {

				echo self::$succesMessageMail; 
			}
		
		
		}

	}