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
			return $this->contact->getEmail();
		}

		public function getContactMsg() {
			return $this->contact->getMsg();
		}

		public function didPressSend() {
			return $this->contact->hasSubmitToSend();
		}

		//Send input to validation method.
		public function sendContactFormInfo() {
			$Name = $this->getContctName();
			$Email = $this->getContactEmail();
			$Message = $this->getContactMsg();
			$this->validation->ContactFormValidation($Name,$Email,$Message);
		}

		//Render contact form and make sure that all is right to make a contact message.
		public function doContact() {
			$this->contact->RenderContactForm();

			$Name = $this->getContctName();
			$Email = $this->getContactEmail();
			$Message = $this->getContactMsg();

			if ($this->didPressSend() == true) {
				
				if ($this->validation->ContactFormValidation($Name,$Email,$Message) === true) {

			    		$messages = "Namn:\r\n" .$Name."\r\nEpost:\r\n". $Email."\r\nMeddelandet:\r\n".$Message;
						$headers  = "From:".$Email."\r\n";
			    		$headers .= "Reply-To:" .$Email;
			    		$headers .= "MIME-Version: 1.0\r\n";
			    		$headers .= "Content-type: text/plain; charset=utf-8\r\n";

    				    $this->emailContact->EmailContact($messages,$headers);
				}
				else {
					return $this->contact->ContactForm($this->validation->ContactFormValidation($Name,$Email,$Message));
				}
				

			}

		}

	}