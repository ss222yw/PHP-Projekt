<?php

	class emailContact {

		private static $to = "ss222yw@student.lnu.se";
		private static $subj = "Nytt Meddelande";
		private static $succesMessageMail = '<div class="alert alert-success alert-dismissible" role="alert">
  							 				 <button type="button" class="close" data-dismiss="alert">
  											 <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										     <strong>Ditt meddelande har skickats. Tack!</strong></div><br><br>';


		public function __construct() {

		}
		// Mail function to send a message by contact from.
		public function EmailContact($message, $header) {
			if (mail(self::$to, self::$subj, $message, $header)) {

				echo self::$succesMessageMail; 
			}

		}

	}