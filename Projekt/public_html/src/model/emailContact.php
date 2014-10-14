<?php

	class emailContact {

		private static $to = "ss222yw@student.lnu.se";
		private static $subj = "Nytt Meddelande";
		private static $succesMessageMail = "Ditt meddelande har skickats. Tack!<br><br>";


		public function __construct() {

		}

		public function EmailContact($message, $header) {
			if (mail(self::$to, self::$subj, $message, $header)) {

				echo self::$succesMessageMail; 
			}

		}

	}