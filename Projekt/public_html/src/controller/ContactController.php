<?php
	
	class ContactController {

		private $validation;
		private $contact;
		private $emailContact;


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
			//var_dump($this->contact->getEmail());
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
 

		// public function MessagesAndHeaders() {

		// 	$Name = $this->getContctName();
		// 	$Email = $this->getContactEmail();
		// 	$Message = $this->getContactMsg();

		// }

	
		// public function getNameToEContact() {
		// 	$this->emailContact->getName($this->getContctName());
		// }

		// public function getEmailToContact() {

		// 	$this->emailContact->getEmail($this->getContactEmail());
		// }

		// public function getMsgToContact() {
		// 	$this->emailContact->getMessage($this->getContactMsg());
		// }

		public function doContact() {

			$this->contact->RenderContactForm();

			$Name = $this->getContctName();
			$Email = $this->getContactEmail();
			$Message = $this->getContactMsg();
			

			if ($this->didPressSend() == true) {
				if ($this->validation->ContactFormValidation($Name,$Email,$Message) === true) {
						$messages = "Namn: $Name\r\nEpost: $Email\r\nMeddelandet: $Message";


			$Email = $this->getContactEmail();
			$headers = 'From: $Email' . "\r\n" .
    						 'Reply-To: webmaster@example.com' .
    						 'Content-type: text/plain; charset=UTF-8'."\r\n";	

    		$this->emailContact->EmailContact($messages,$headers);
				}
				else {
					return $this->contact->ContactForm($this->validation->ContactFormValidation($Name,$Email,$Message));
				}
				

			}

		}

	}