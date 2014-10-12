<?php
	
	class ContactController {

		private $validation;


		public function __construct() {

			$this->contact = new contact();
			$this->validation = new validation();
			$this->emailContact = new emailContact();
		}


		//funcations for contact from 
		public function getContctName() {
			return $this->contact->getName();
		}

		public function getContactEmail() {
			return $this->contact->getEmail();
		}

		public function getContactMsg() {
			return $this->contact->getMsg();
		}

		public function didPressSend() {
			return $this->contact->hasSubmitToSend();
		}

		public function sendContactFormInfo() {
			$Name = $this->getContctName();
			$Email = $this->getContactEmail();
			$Message = $this->getContactMsg();
			$this->validation->ContactFormValidation($Name,$Email,$Message);
		}


		public function getNameToEContact() {
			$this->emailContact->getName($this->getContctName());
		}

		public function getEmailToContact() {
			$this->emailContact->getEmail($this->getContactEmail());
		}

		public function getMsgToContact() {
			$this->emailContact->getMessage($this->getContactMsg());
		}

		public function doContact() {
			//TODO:: MOVE IT/..
			$this->contact->RenderContactForm();

			$Name = $this->getContctName();
			$Email = $this->getContactEmail();
			$Message = $this->getContactMsg();
			if ($this->didPressSend() == true) {
				# code...
				if ($this->validation->ContactFormValidation($Name,$Email,$Message) === true) {
					# code...
					//TODO:: Code for contact form....
					$this->emailContact->EmailContact();
				}
				else {
					return $this->contact->ContactForm($this->validation->ContactFormValidation($Name,$Email,$Message));
				}
				

			}

		}

	}