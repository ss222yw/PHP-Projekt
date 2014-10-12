<?php

	class contact {

		private $name = "name";
		private $email = "email";
		private $msg = "message";
		
		private $mainView;	

		public function __construct() {
			$this->mainView = new HTMLView();
		}


		public function ContactForm($message = '') {

			$responseMessages = ''; 
			if ($message != '') {
					
				$responseMessages .= '<p>' . $message . '</p>';
			}
			echo $responseMessages;
			$contactUs =
			'<form id="contact"  method="post" action="">'.
			'<label>Ditt namn : </label>'.
			'<input type="text" name="'.$this->name.'" maxlength="30">' .
			'<label>Din epost : </label>'.
			'<input type="text" name="'.$this->email.'" maxlength="50">' .
			'<label>Ditt meddelande : </label>'.
			'<br>'.
			'<textarea name="'.$this->msg.'" cols="50" rows="5" maxlength="500"></textarea>' .
			'<br>'.
			'<input type="submit" name="send" value="Skicka">'.
			'</form>';
			return $contactUs;
		}

		public function RenderContactForm($errorMessage = '') {

			echo $this->mainView->echoHTML($this->ContactForm($errorMessage));
		}


		public function getName() {
			if (isset($_POST[$this->name])) {
				# code...
				return htmlentities($_POST[$this->name]);
			}
		}

		public function getEmail() {
			if (isset($_POST[$this->email])) {
				# code...
				return htmlentities($_POST[$this->email]);
			}
		}

		public function getMsg() {
			if (isset($_POST[$this->msg])) {
				# code...
				return htmlentities($_POST[$this->msg]);
			}
		}

		public function hasSubmitToSend() {
			if (isset($_POST['send'])) {
				# code...
				return true;
			}
			return false;

		}

	}