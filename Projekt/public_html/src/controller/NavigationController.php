<?php

	class NavigationController {

		private $available;
		private $navigationView;
		private $controller;
		private $contactController;
		private $uploadController;
		private $AdminID;
		private $sessionModel;
		private $memberView;
		private $homePageView;



		public function __construct() {

			$this->navigationView = new NavigationView();
			$this->controller = new LoginController();
			$this->contactController = new ContactController();
			$this->uploadController = new UploadController();
			$this->sessionModel = new SessionModel();
			$this->memberView = new MemberView();
			$this->available = new available();
			$this->homePageView = new HomePageView();
		} 

		public function doControll() {
			$this->navigationView->renderShowMenu();
			try {

				switch ($this->navigationView->getPage()) {
					// case NavigationView::$registrera:
					// 	# code...
					// 	break;
					case NavigationView::$Avaliable:
						# code...
							   $this->controller->RunLoginLogic();
						return $this->available->renderAllPics();
						break;
					case NavigationView::$HomePage:
					 	# code...		
								$this->controller->RunLoginLogic();
						return 	$this->homePageView->renderHomePage();
					 	break;		
					case NavigationView::$contact:
						# code...
								$this->controller->RunLoginLogic();
						return $this->contactController->doContact();
						break;
					case NavigationView::$upload:
						# code...
						if ($this->AdminID == 1 || $this->sessionModel->IsAdminLoggedIn() &&
							 $this->sessionModel->IsLoggedIn() || ($this->memberView->RememberMe() &&
							 										 $this->memberView->RememberAdmin()))  {

								   $this->controller->RunLoginLogic();		
							return $this->uploadController->imgUpload();

						}

						break;
					case NavigationView::$interest:
						# code...
						$this->controller->RunLoginLogic();
						break;
					case NavigationView::$service:
						# code...
						$this->controller->RunLoginLogic();
						break;			

					default:
						# code...
						return $this->controller->RunLoginLogic();
						break;	
				}
				
			} 
			catch (Exception $e) {
				error_log($e->getMessage() . "\n", 3, \setting::$ERROR_LOG);
				if (setting::$DO_DEBUG) {
					# code...
					throw $e;
				}
				else {
					$this->navigationView->RedirectToErrorPage();
					die();
				}
			}


		}
	}