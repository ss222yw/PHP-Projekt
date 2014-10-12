<?php

	class interestView {

		private $name = "name";
		private $email = "email";
		private $msg = "message";
		private $send = "send";
		
		private $mainView;	

		public function __construct() {
			$this->mainView = new HTMLView();
		}


		public function interestFrom() {
			$Interest =
			'<h4>Sökande</h4>'.
			'<form id="interest" enctype="multipart/form-data" method="post" action="">'.
			'<label>Ditt namn : </label>'.
			'<input type="text" name="'.$this->name.'">' .
			'<label>Din epost : </label>'.
			'<input type="text" name="'.$this->email.'">' .
			'<label>Önskemål & Inflyttningsdatum : </label>'.
			'<textarea name="'.$this->msg.'" ></textarea>' .
			'<input type="submit" name"'.$this->send.'" value="Skicka intresseanmälan">'.
			'</form>';
			return $Interest;
		}

		public function RenderinterestFrom() {

			echo $this->mainView->echoHTML($this->interestFrom());
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

		public function hasSubmitToIntreset() {
			if (isset($_POST[$this->send])) {
				# code...
				return true;
			}
		}

	}