<?php

	class emailContact {

		private static $to = "ss222yw@student.lnu.se";
		private static $subj = "Ny Meddelande";
		private $message;
		private $headers;
		private $name;
		private $email;
		private $msg;


		public function __construct() {

			$this->message = "Namn: $this->name\r\nEpost: $this->email\r\nMeddelandet: $this->msg";
			$this->headers = 'From: $this->email' . "\r\n" .
    						 'Reply-To: webmaster@example.com' .
    						 'Content-type: text/plain; charset=UTF-8'."\r\n";	
		}

		public function getName($Name) {
			$this->name = $Name;
		}

		public function getEmail($Email) {
			$this->email = $Email;
		}

		public function getMessage($MSG) {
			$this->msg = $MSG;
		}


		public function EmailContact() {
		
			mail(self::$to, self::$subj, $this->message, $this->headers);
		}


	}