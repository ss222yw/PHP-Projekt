<?php 
	

	//the require once here just to show the coupling between classes.	
	require_once(ViewPath.DS.'serviceView.php');
	require_once(ModelPath.DS.'validation.php');
	require_once(ModelPath.DS.'emailService.php');

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
		private function getServiceName() {
			return $this->service->getName();
		}

		private function getServiceEmail() {
			return $this->service->getEmail();
		}

		private function getServiceMsg() {
			return $this->service->getMsg();
		}

		private function getServiceTel() {
			return $this->service->getTel();
		}

		private function getServiceAprtNr() {
			return $this->service->getAprtNumber();
		}

		private function didPressSend() {
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
					//Parameters send to mail fucntion.
				   	$messages = "Namn:\r\n" .$Name."\r\nEpost:\r\n". $Email."\r\nMeddelandet:\r\n".$Message;
					$headers  = "From:".$Email."\r\n";
			    	$headers .= "Reply-To:" .$Email;
			    	$headers .= "MIME-Version: 1.0\r\n";
			    	$headers .= "Content-type: text/plain; charset=utf-8\r\n";	

					$this->emailService->EmailService($messages,$headers);
				}
				else {
					return $this->service->serviceForm($this->validation->ServiceFormValidation($Name,$Email,$Message,$TEL,$AprtNr));
				}
			}
		}
		
	}