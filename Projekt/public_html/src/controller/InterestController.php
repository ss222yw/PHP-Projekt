<?php
	
	class InterestController {

		private $validation;
		private $interest;
		private $emailInterest;

		public function __construct() {

			$this->validation = new Validation();
			$this->interest = new InterestView();
			$this->emailInterest = new emailInterest();

		}

		//Funcation for interset form.
		public function getInterstName() {
			return $this->interest->getName();
		}

		public function getInterstEmail() {
			return $this->interest->getEmail();
		}

		public function getInterstMsg() {
			return $this->interest->getMsg();
		}

		public function didPressSend() {
			return $this->interest->hasSubmitToIntreset();
		}

		// Send input to validation method.
		public function getInfoForValidtion() {
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