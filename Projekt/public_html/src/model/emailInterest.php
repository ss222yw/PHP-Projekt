<?php
	
	class emailInterest {

		private static $to = "ss222yw@student.lnu.se";
		private static $subj = "Intressanmäla";
		private static $succesMessageMail = '<div class="alert alert-success alert-dismissible" role="alert">
  							 				 <button type="button" class="close" data-dismiss="alert">
  											 <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										     <strong>Vi har tagit emot ditt intressanmäla ,
  										      hör av oss så fort dyker upp en som matchar din önskemål. Tack!</strong></div><br><br>';

		public function __construct() {

		}

		// Mail function to send a message by Interset from.
		public function EmailInterest($messages,$headers) {

			if (mail(self::$to, self::$subj, $messages, $headers)) {

				echo self::$succesMessageMail; 
			}
		
		}

	}