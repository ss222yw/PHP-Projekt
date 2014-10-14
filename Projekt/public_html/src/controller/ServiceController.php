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

		public function getInfoForValidtion() {

			$Name = $this->getServiceName();
			$Email = $this->getServiceEmail();
			$Message = $this->getServiceMsg();
			$TEL = $this->getServiceTel();
			$AprtNr = $this->getServiceAprtNr();
			$this->validation->ServiceFormValidation($Name,$Email,$Message,$TEL,$AprtNr);
		}

		public function getNameToServiceModel() {
			$this->emailService->getName($this->getServiceName());
		}

		public function getEmailToServiceModel() {
			$this->emailService->getEmail($this->getServiceEmail());
		}

		public function getMsgToServiceModel() {
			$this->emailService->getMsg($this->getServiceMsg());
		}

		public function doService() {

			$this->service->RenderServiceForm();

			$Name = $this->getServiceName();
			$Email = $this->getServiceEmail();
			$Message = $this->getServiceMsg();
			$TEL = $this->getServiceTel();
			$AprtNr = $this->getServiceAprtNr();

			if ($this->didPressSend() == true) {
				# code...
				if ($this->validation->ServiceFormValidation($Name,$Email,$Message,$TEL,$AprtNr) === true) {
					# code...
					$this->emailService->EmailService();
				}
				else {
					return $this->service->serviceForm($this->validation->ServiceFormValidation($Name,$Email,$Message,$TEL,$AprtNr));
				}
			}
		}
		
	}