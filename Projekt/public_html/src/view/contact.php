<?php

	class contact {

		private $name = "name";
		private $email = "email";
		private $msg = "message";
		private $send = "send";
		private $GetName;
		private $GetMeg;
		private $GetEmail;
		private $mainView;	
		private $validation;

		public function __construct() {
			$this->mainView = new HTMLView();
			$this->validation = new validation();
		}

		//render contact form.
		public function ContactForm($message = '') {

			if($this->validation->ContactFormValidation($this->getName(),$this->getEmail(),$this->getMsg()) !== true ){
				$this->GetName = $this->getName();
				$this->GetMeg = $this->getMsg();
				$this->GetEmail = $this->getEmail();
			}

			$responseMessages = ''; 
			if ($message != '') {
					
				$responseMessages .= '<strong>' . $message . '</strong>';
			}

			echo '<h3>'.$responseMessages.'</h3>';

			$contactUs =
			'<form id="contact"  method="post" action="">'.
			'<fieldset class="contact">' .
			'<legend><h3>Var vänlig och kontakta oss</h3></legend>' .
			'<label><strong>Ditt namn</strong> : </label>'.
			'<input type="text" name="'.$this->name.'" maxlength="30" value="'.$this->GetName.'" placeholder="Namnet krävs">' .
			'<br>'.
			'<label><strong>Din epost</strong> : </label>'.
			'<input type="text" name="'.$this->email.'" maxlength="50"placeholder="Epost krävs" value="'.$this->GetEmail.'">' .
			'<br>'.
		 	'<label><strong>Ditt meddelande</strong> : </label>'.
			'<br>'.
			'<textarea name="'.$this->msg.'" cols="45" rows="5" maxlength="500" placeholder="Skriv ditt meddelande här..." wrap="hard">'.$this->GetMeg.'</textarea>' .
			'<br>'.
			'<br>'.
			'<input type="submit" name="'.$this->send.'" value="Skicka">'.
			'</fieldset>'.
			'</form>';
			return $contactUs;
		}

		public function RenderContactForm($errorMessage = '') {

			echo $this->mainView->echoHTML($this->ContactForm($errorMessage));
		}


		public function getName() {
			if (isset($_POST[$this->name])) {
				return htmlentities($_POST[$this->name]);
			}
		}

		public function getEmail() {
	 		if (isset($_POST[$this->email])) {
				return htmlentities($_POST[$this->email]);
			}
		}

		public function getMsg() {
			if (isset($_POST[$this->msg])) {
				$message = nl2br($_POST[$this->msg]);
				return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $message);
			}
		}

		public function hasSubmitToSend() {
			if (isset($_POST[$this->send])) {
				return true;
			}
			return false;

		}

	}