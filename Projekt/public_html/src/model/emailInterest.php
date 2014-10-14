<?php
	
	class emailInterest {

		private static $to = "ss222yw@student.lnu.se";
		private static $subj = "Intressanmäla";
		private static $succesMessageMail = "Vi har tagit emot ditt intressanmäla , hör av oss så fort dyker upp en som matchar din önskemål. Tack!<br><br>";





		public function __construct() {

		}


		public function EmailInterest($messages,$headers) {

			if (mail(self::$to, self::$subj, $messages, $headers)) {

				echo self::$succesMessageMail; 
			}
		
		}

	}