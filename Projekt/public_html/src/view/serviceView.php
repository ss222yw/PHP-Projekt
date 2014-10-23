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
					
				$responseMessages .= '<strong>' . $message . '</strong>';
			}

			echo '<h3>'.$responseMessages.'</h3>';

			$service =
			'<h2>Felanmälan</h2>'.
			'<form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="">'.
			'<div class="form-group">'.
			'<div class="col-xs-4">'.
			'<label>Ditt namn : </label>'.
			'<input type="text" name="'.$this->name.'" maxlength="30" class="form-control" placeholder="Namnet krävs" value="'.$this->GetName.'">' .
			'</div>'.
			'</div>'.
			'<div class="form-group">'.
			'<div class="col-xs-4" >'.
			'<label>Lgh Nr : </label>'.
			'<input type="text" name="'.$this->aprtM.'" maxlength="10" class="form-control" placeholder="Frivilligt" value="'.$this->GetApartNr.'">' .
			'</div>'.
			'</div>'.
			'<div class="form-group">'.
			'<div class="col-xs-4">'.
			'<label>Din epost : </label>'.
			'<input type="email" name="'.$this->email.'" maxlength="50" class="form-control" placeholder="Epost krävs" value="'.$this->GetEmail.'">' .
			'</div>'.
			'</div>'.
			'<div class="form-group">'.
			'<div class="col-xs-4">'.
			'<label>Telefon : </label>'.
			'<input type="tel" name="'.$this->tel.'" maxlength="30" class="form-control"  placeholder="Frivilligt" value="'.$this->GetTel.'">' .
			'</div>'.
			'</div>'.
			'<div class="form-group">'.
			'<div class="col-xs-4">'.
			'<label>Ditt anmäla : </label>'.
			'<textarea name="'.$this->msg.'" maxlength="500" cols="45" class="form-control" rows="5" placeholder="Beskriv ditt felanmäla här..." wrap="hard">'.$this->GetMeg.'</textarea>' .
			'</div>'.
			'</div>'.
			'<input type="submit" name="'.$this->send.'" value="Skicka felanmäla" class="btn btn-default">'.
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