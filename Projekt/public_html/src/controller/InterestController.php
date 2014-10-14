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

		public function getInfoForValidtion() {
			$Name = $this->getInterstName();
			$Email = $this->getInterstEmail();
			$Message = $this->getInterstMsg();
			$this->validation->InterestFormValidation($Name,$Email,$Message);
		}

		public function getNameToInterestModel() {
			$this->emailInerest->getName($this->getInterstName());
		}	

		public function getEmailToInterestModel() {
			$this->emailInerest->getEmail($this->getInterstEmail());
		}

		public function getMsgToInterestModel() {
			$this->emailInerest->getMessage($this->getInterstMsg());
		}

		public function doInterest() {

			$this->interest->RenderinterestFrom();
			if ($this->didPressSend() == true) {
				# code...
				if ($this->validation->InterestFormValidation($this->getInterstName(),$this->getInterstEmail(),$this->getInterstMsg()) === true)  {
					# code...
					$this->emailInterest->EmailInterest();
				}
				else {
					return $this->interest->interestFrom($this->validation->InterestFormValidation($this->getInterstName(),$this->getInterstEmail(),$this->getInterstMsg()));
				}
			}
		}

	}