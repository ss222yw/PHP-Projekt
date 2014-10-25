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

		//render interest form.
		public function interestFrom($message = '') {

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

			$Interest =
			'<h2>Sökande</h2>'.
			'<form class="form-horizontal" enctype="multipart/form-data" method="post" action="">'.
			'<label>Ditt namn : </label>'.
			'<input type="text" name="'.$this->name.'" value="'.$this->GetName.'" maxlength="30" class="form-control" placeholder="Namnet krävs">' .
			'<label>Din epost : </label>'.
			'<input type="text" name="'.$this->email.'" maxlength="50"  class="form-control" placeholder="epost krävs" value="'.$this->GetEmail.'">' .
			'<label>Önskemål & Inflyttningsdatum : </label>'.
			'<textarea name="'.$this->msg.'" maxlength="500" cols="45" rows="5" class="form-control" placeholder="Beskriv din önskemål här..." wrap="hard">'.$this->GetMeg.'</textarea>' .
			'<input type="submit" name= "'.$this->send.'" value="Skicka intresseanmälan" class="btn btn-default">'.
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
				$message = nl2br($_POST[$this->msg]);
				return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $message );
			}
		}

		public function hasSubmitToIntreset() {
			if (isset($_POST[$this->send])) {
				return true;
			}
		}

	}