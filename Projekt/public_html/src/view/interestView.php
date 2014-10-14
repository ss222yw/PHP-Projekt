<?php

	class interestView {

		private $name = "name";
		private $email = "email";
		private $msg = "message";
		private $send = "send";
		private $GetName;
		private $GetEmail;
		private $validation;
		private $mainView;	

		public function __construct() {
			$this->mainView = new HTMLView();
			$this->validation = new validation();
		}


		public function interestFrom($message = '') {

			if($this->validation->ContactFormValidation($this->getName(),$this->getEmail(),$this->getMsg()) !== true ){
				$this->GetName = $this->getName();
				$this->GetMeg = $this->getMsg();
				$this->GetEmail = $this->getEmail();
			}

			$responseMessages = ''; 
			if ($message != '') {
					
				$responseMessages .= '<p>' . $message . '</p>';
			}

	 		echo '<h3>'.$responseMessages.'</h3>';

			$Interest =
			'<form id="interest" enctype="multipart/form-data" method="post" action="">'.
			'<fieldset class="interest">' .
			'<legend><h3>Sökande</h3></legend>' .
			'<label>Ditt namn : </label>'.
			'<input type="text" name="'.$this->name.'" value="'.$this->GetName.'" maxlength="30" placeholder="Namnet krävs">' .
			'<br>'.
			'<label>Din epost : </label>'.
			'<input type="text" name="'.$this->email.'" maxlength="50" placeholder="epost krävs" value="'.$this->GetEmail.'">' .
			'<br>'.
			'<label>Önskemål & Inflyttningsdatum : </label>'.
			'<br>'.
			'<textarea name="'.$this->msg.'" maxlength="500" cols="45" rows="5" placeholder="Beskriv din önskemål här...">'.$this->GetMeg.'</textarea>' .
			'<br>'.
			'<br>'.
			'<input type="submit" name= "'.$this->send.'" value="Skicka intresseanmälan">'.
			'</fieldset>'.
			'</form>';
			return $Interest;
		}
 
		public function RenderinterestFrom($errorMessage = '') {

			echo $this->mainView->echoHTML($this->interestFrom($errorMessage));
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
				return htmlentities($_POST[$this->msg]);
			}
		}

		public function hasSubmitToIntreset() {
			if (isset($_POST[$this->send])) {
				return true;
			}
		}

	}