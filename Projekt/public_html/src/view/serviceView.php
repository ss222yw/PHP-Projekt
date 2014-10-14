<?php

	class serviceView {

		private $name = "name";
		private $email = "email";
		private $msg = "message";
		private $send = "send";
		private $aprtM = "aprtM";
		private $tel = "tel";
		
		private $mainView;	

		public function __construct() {
			$this->mainView = new HTMLView();
		}


		public function serviceForm($message = '') {

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
			'<input type="text" name="'.$this->name.'" maxlength="30" placeholder="Namnet krävs" value="'.$this->getName().'">' .
			'<br>'.
			'<label>Lgh Nr : </label>'.
			'<input type="text" name="'.$this->aprtM.'" maxlength="10" placeholder="Frivilligt" value="'.$this->getAprtNumber().'">' .
			'<br>'.
			'<label>Din epost : </label>'.
			'<input type="text" name="'.$this->email.'" maxlength="50" placeholder="Epost krävs" >' .
			'<br>'.
			'<label>Telefon : </label>'.
			'<input type="text" name="'.$this->tel.'" maxlength="30" placeholder="Frivilligt" value="'.$this->getTel().'">' .
			'<br>'.
			'<label>Ditt anmäla : </label>'.
			'<br>'.
			'<textarea name="'.$this->msg.'" maxlength="500" cols="45" rows="5" placeholder="Beskriv ditt felanmäla här...">'.$this->getMsg().'</textarea>' .
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

		public function getTel() {
			if (isset($_POST[$this->tel])) {
				# code...
				return htmlentities($_POST[$this->tel]);
			}
		}

		public function getAprtNumber() {
			if (isset($_POST[$this->aprtM])) {
				# code...
				return htmlentities($_POST[$this->aprtM]);
			}
		}

		public function hasSubmitToService() {
			if (isset($_POST[$this->send])) {
				# code...
				return true;
			}
		}

	}