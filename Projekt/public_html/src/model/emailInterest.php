<?php
	
	class emailInterest {

		private static $to = "ss222yw@student.lnu.se";
		private static $subj = "Intressanmäla";
		private static $succesMessageMail = "<p class='bg-success'>Vi har tagit emot ditt intressanmäla , hör av oss så fort dyker upp en som matchar din önskemål. Tack!</p><br><br>";


		public function __construct() {

		}

		// Mail function to send a message by Interset from.
		public function EmailInterest($messages,$headers) {

			if (mail(self::$to, self::$subj, $messages, $headers)) {

				echo self::$succesMessageMail; 
			}
		
		}

	}