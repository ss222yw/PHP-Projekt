<?php
	

	//the require once here just to show the coupling between classes.	
	require_once(ViewPath.DS.'interestView.php');
	require_once(ModelPath.DS.'validation.php');
	require_once(ModelPath.DS.'emailInterest.php');

	class InterestController {

		private $validation;
		private $interest;
		private $emailInterest;

		public function __construct() {

			$this->validation = new Validation();
			$this->interest = new interestView();
			$this->emailInterest = new emailInterest();

		}

		//Funcation for interset form.
		private function getInterstName() {
			return $this->interest->getName();
		}

		private function getInterstEmail() {
			return $this->interest->getEmail();
		}

		private function getInterstMsg() {
			return $this->interest->getMsg();
		}

		private function didPressSend() {
			return $this->interest->hasSubmitToIntreset();
		}

		// Send input to validation method.
		private function getInfoForValidtion() {
			$Name = $this->getInterstName();
			$Email = $this->getInterstEmail();
			$Message = $this->getInterstMsg();
			$this->validation->InterestFormValidation($Name,$Email,$Message);
		}

		//Render interset form and make sure that all is ok to make a interset message.
		public function doInterest() {

			$this->interest->RenderinterestFrom();

			$Name = $this->getInterstName();
			$Email = $this->getInterstEmail();
			$Message = $this->getInterstMsg();

			if ($this->didPressSend() == true) {

				if ($this->validation->InterestFormValidation($this->getInterstName(),$this->getInterstEmail(),$this->getInterstMsg()) === true)  {
						//Parameters sends to mail function.
						$messages = "Namn:\r\n" .$Name."\r\nEpost:\r\n". $Email."\r\nMeddelandet:\r\n".$Message;
						$headers  = "From:".$Email."\r\n";
			    		$headers .= "Reply-To:" .$Email;
			    		$headers .= "MIME-Version: 1.0\r\n";
			    		$headers .= "Content-type: text/plain; charset=utf-8\r\n";


						$this->emailInterest->EmailInterest($messages,$headers);
				}
				else {
					return $this->interest->interestFrom($this->validation->InterestFormValidation($this->getInterstName(),$this->getInterstEmail(),$this->getInterstMsg()));
				}
			}
		}

	}