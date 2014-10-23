<?php
ob_start();

	//the require once here just to show the coupling between classes.
	require_once(ViewPath.DS.'NavigationView.php');
	require_once(ControllerPath.DS.'LoginController.php');
	require_once(ControllerPath.DS.'UploadController.php');
	require_once(ControllerPath.DS.'ContactController.php');
	require_once(ModelPath.DS.'UserModel.php');
	require_once(ViewPath.DS.'LoginView.php');
	require_once(ViewPath.DS.'MemberView.php');
	require_once(ModelPath.DS.'SessionModel.php');
	require_once(ModelPath.DS.'User.php');
	require_once(ViewPath.DS.'CookieStorage.php');
	require_once(ViewPath.DS.'HomePageView.php');
	require_once(ControllerPath.DS.'InterestController.php');
	require_once(ControllerPath.DS.'ServiceController.php');
	require_once(ViewPath.DS.'available.php');



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
		private $interestController;
		private $serviceController;
		private $loginView;



		public function __construct() {

			$this->navigationView = new NavigationView();
			$this->controller = new LoginController();
			$this->contactController = new ContactController();
			$this->uploadController = new UploadController();
			$this->sessionModel = new SessionModel();
			$this->memberView = new MemberView();
			$this->available = new available();
			$this->homePageView = new HomePageView();
			$this->interestController = new InterestController();
			$this->serviceController = new ServiceController();
			$this->loginView = new LoginView();
		} 

		//Render menu.
		public function doControll() {
					
		$this->navigationView->renderShowMenu();
			try {
					 
					
				switch ($this->navigationView->getPage()) {
					

					case NavigationView::$Avaliable:
					//If Admin presss log in , is Admin is logged in , or is Admin logged width cookies DO...
					if ($this->loginView->UserPressLoginButton() && $this->controller->AuthenticateUser() === true && $this->AdminID == 1 || $this->sessionModel->IsAdminLoggedIn() &&
							 $this->sessionModel->IsLoggedIn() || $this->memberView->RememberMe() && substr($this->memberView->GetCookiePassword(), -1) == 1)  {

						$this->controller->RunLoginLogic();
						$this->uploadController->removeImageFromFolder();
					    $this->available->renderAllPics();	

					     if ($this->memberView->UserPressLogoutButton()) {
					     	 
							 header('Location: ?page=Avaliable');

						 }
					}

					else {
							   $this->controller->RunLoginLogic();
						return $this->available->renderAllPicsForUsers();
					}
						break;
					case NavigationView::$HomePage:
								$this->controller->RunLoginLogic();
						return 	$this->homePageView->renderHomePage();
					 	break;		
					case NavigationView::$contact:
								$this->controller->RunLoginLogic();
						return $this->contactController->doContact();
						break;
					case available::$upload:
						if ($this->AdminID == 1 || $this->sessionModel->IsAdminLoggedIn() &&
							 $this->sessionModel->IsLoggedIn() || $this->memberView->RememberMe() && substr($this->memberView->GetCookiePassword(), -1) == 1) {

								   $this->controller->RunLoginLogic();		
								   $this->uploadController->imgUpload();

								    if ($this->memberView->UserPressLogoutButton()) {
										 header('Location: ?page=Avaliable');
									 }


						}
						else {
							$this->controller->RunLoginLogic();
						}

						break;
					case NavigationView::$interest:
						# code...
					if ($this->sessionModel->IsLoggedIn() || $this->memberView->RememberMe()|| $this->loginView->UserPressLoginButton() && $this->controller->AuthenticateUser() === true)  {

								$this->controller->RunLoginLogic();
							    $this->interestController->doInterest(); 

							    if ($this->memberView->UserPressLogoutButton()) {
							    	header('Location: ?page=interest');
							    }
					}
					else {
						$this->controller->RunLoginLogic();
						echo '<div class="alert alert-danger alert-dismissible" role="alert">
  							  <button type="button" class="close" data-dismiss="alert">
  							  <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  							  <strong>Logga in</strong> först för att kunna skicka intressanmälan!</div><br><br>';
					}
						break;
					case NavigationView::$service:
					if ($this->sessionModel->IsLoggedIn() || $this->memberView->RememberMe()|| $this->loginView->UserPressLoginButton() && $this->controller->AuthenticateUser() === true)  {
						# code...
						$this->controller->RunLoginLogic();
					    $this->serviceController->doService();

					      if ($this->memberView->UserPressLogoutButton()) {
							  header('Location: ?page=service');
						   }
					}
					else {
						$this->controller->RunLoginLogic();
						echo '<div class="alert alert-danger alert-dismissible" role="alert">
  							  <button type="button" class="close" data-dismiss="alert">
  							  <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  							  <strong>Logga in</strong> först för att kunna skicka anmälan!</div><br><br>';
					}
						break;			

					default:
						return $this->controller->RunLoginLogic();
						break;	
				}
				
			} 
			catch (Exception $e) {
				error_log($e->getMessage() . "\n", 3, \setting::$ERROR_LOG);
				if (setting::$DO_DEBUG) {
					throw $e;
				}
				else {
					$this->navigationView->RedirectToErrorPage();
					die();
				}
			}

			

		}
	}

	ob_flush();