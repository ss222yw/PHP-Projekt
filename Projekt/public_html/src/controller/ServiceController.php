<?php 
	
	class ServiceController {

		private $validation;
		private $service;
		private $emailService;

		public function __construct() {

			$this->validation = new Validation();
			$this->service = new serviceView();
			$this->emailService = new emailService();

		}

		//Funcations for service form.
		public function getServiceName() {
			return $this->service->getName();
		}

		public function getServiceEmail() {
			return $this->service->getEmail();
		}

		public function getServiceMsg() {
			return $this->service->getMsg();
		}

		public function getServiceTel() {
			return $this->service->getTel();
		}

		public function getServiceAprtNr() {
			return $this->service->getAprtNumber();
		}

		public function didPressSend() {
			return $this->service->hasSubmitToService();
		}

		//Send input to validation method.
		public function getInfoForValidtion() {

			$Name = $this->getServiceName();
			$Email = $this->getServiceEmail();
			$Message = $this->getServiceMsg();
			$TEL = $this->getServiceTel();
			$AprtNr = $this->getServiceAprtNr();
			$this->validation->ServiceFormValidation($Name,$Email,$Message,$TEL,$AprtNr);
		}

		// Render service form and make sure that everything is ok to make a servie message.
		public function doService() {

			$this->service->RenderServiceForm();

			$Name = $this->getServiceName();
			$Email = $this->getServiceEmail();
			$Message = $this->getServiceMsg();
			$TEL = $this->getServiceTel();
			$AprtNr = $this->getServiceAprtNr();

			if ($this->didPressSend() == true) {
				if ($this->validation->ServiceFormValidation($Name,$Email,$Message,$TEL,$AprtNr) === true) {

				    $messages = "Namn:<br>" .$Name."<br><br>\r\nEpost:<br>". $Email."<br><br>\r\nTel:<br>".$TEL."<br><br>\r\nLägenhetesNummer:<br>".$AprtNr."<br><br>\r\nMeddelandet:<br>".$Message;
					$headers  = "From:<br>".$Email."\r\n";
			    	$headers .= "Reply-To:" .$Email;
			    	$headers .= "MIME-Version: 1.0\r\n";
			    	$headers .= "Content-type: text/html; charset=utf-8\r\n";	

					$this->emailService->EmailService($messages,$headers);
				}
				else {
					return $this->service->serviceForm($this->validation->ServiceFormValidation($Name,$Email,$Message,$TEL,$AprtNr));
				}
			}
		}
		
	}