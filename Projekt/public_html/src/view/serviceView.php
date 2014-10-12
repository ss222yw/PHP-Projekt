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


		public function serviceForm() {
			$service =
			'<form id="interest" enctype="multipart/form-data" method="post" action="">'.
			'<label>Ditt namn : </label>'.
			'<input type="text" name="'.$this->name.'">' .
			'<label>Lgh Nr : </label>'.
			'<input type="text" name="'.$this->aprtM.'">' .
			'<label>Din epost : </label>'.
			'<input type="text" name="'.$this->email.'">' .
			'<label>Telefon : </label>'.
			'<input type="text" name="'.$this->tel.'">' .
			'<label>Önskemål & Inflyttningsdatum : </label>'.
			'<textarea name="'.$this->msg.'" ></textarea>' .
			'<input type="submit" name"'.$this->send.'" value="Skicka intresseanmälan">'.
			'</form>';
			return $service;
		}

		public function RenderServiceForm() {

			echo $this->mainView->echoHTML($this->serviceForm());
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