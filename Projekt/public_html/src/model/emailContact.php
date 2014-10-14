<?php

	class emailContact {

		private static $to = "ss222yw@student.lnu.se";
		private static $subj = "Ny Meddelande";
		// private $message;
		// private $headers;
		// private $name;
		// private $email;
		// private $msg;


		public function __construct() {

		}

		// public function getName($Name) {
		// 	//var_dump($Name);
		// 	$this->name = $Name;
		// }

		// public function getEmail($Email) {
		// 	$this->email = $Email;
		// }

		// public function getMessage($MSG) {
		// 	$this->msg = $MSG;
		// }


		public function EmailContact($message, $header) {
			var_dump($message);


		
			mail(self::$to, self::$subj, $message, $header);
		}


	}