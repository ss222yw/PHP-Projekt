<?php

	class serviceView {

		private $name = "name";
		private $email = "email";
		private $msg = "message";
		private $send = "send";
		private $aprtM = "aprtM";
		private $tel = "tel";
		private $GetName;
		private $GetMeg;
		private $GetTel;
		private $GetApartNr;
		private $GetEmail;
		private $validation;
		private $mainView;	

		public function __construct() {
			$this->mainView = new HTMLView();
			$this->validation = new validation();
		}

		//render service form.
		public function serviceForm($message = '') {

			if($this->validation->ContactFormValidation($this->getName(),$this->getEmail(),$this->getMsg(),$this->getTel(),$this->getAprtNumber()) !== true ){
				$this->GetName = $this->getName();
				$this->GetMeg = $this->getMsg();
				$this->GetEmail = $this->getEmail();
				$this->GetTel = $this->getTel();
				$this->GetApartNr = $this->getAprtNumber();
			}

			$responseMessages = ''; 
			if ($message != '') {
					
				$responseMessages .= '<p>' . $message . '</p>';
			}

			echo '<h3>'.$responseMessages.'</h3>';

			$service =
			'<form id="interest" enctype="multipart/form-data" method="post" action="">'.
			'<fieldset class="contact">' .
			'<legend><h3>Felanmäla</h3></legend>' .
			'<label>Ditt namn : </label>'.
			'<input type="text" name="'.$this->name.'" maxlength="30" placeholder="Namnet krävs" value="'.$this->GetName.'">' .
			'<br>'.
			'<label>Lgh Nr : </label>'.
			'<input type="text" name="'.$this->aprtM.'" maxlength="10" placeholder="Frivilligt" value="'.$this->GetApartNr.'">' .
			'<br>'.
			'<label>Din epost : </label>'.
			'<input type="text" name="'.$this->email.'" maxlength="50" placeholder="Epost krävs" value="'.$this->GetEmail.'">' .
			'<br>'.
			'<label>Telefon : </label>'.
			'<input type="text" name="'.$this->tel.'" maxlength="30" placeholder="Frivilligt" value="'.$this->GetTel.'">' .
			'<br>'.
			'<label>Ditt anmäla : </label>'.
			'<br>'.
			'<textarea name="'.$this->msg.'" maxlength="500" cols="45" rows="5" placeholder="Beskriv ditt felanmäla här...">'.$this->GetMeg.'</textarea>' .
			'<br>'.
			'<input type="submit" name="'.$this->send.'" value="Skicka felanmäla">'.
			'</fieldset>'.
			'</form>';
			return $service;
		}

		public function RenderServiceForm($errorMessage = '') {

			echo $this->mainView->echoHTML($this->serviceForm($errorMessage));
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
				return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $message );
			}
		}

		public function getTel() {
			if (isset($_POST[$this->tel])) {
				return htmlentities($_POST[$this->tel]);
			}
		}

		public function getAprtNumber() {
			if (isset($_POST[$this->aprtM])) {
				return htmlentities($_POST[$this->aprtM]);
			}
		}

		public function hasSubmitToService() {
			if (isset($_POST[$this->send])) {
				return true;
			}
		}

	}