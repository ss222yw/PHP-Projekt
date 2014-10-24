<?php
	
	//the require once here just to show the coupling between classes.
	require_once(ModelPath.DS.'UserModel.php');
	require_once(HelperPath.DS.'HTMLView.php');
	require_once(ViewPath.DS.'LoginView.php');
	require_once(ViewPath.DS.'MemberView.php');
	require_once(ViewPath.DS.'RegView.php');
	require_once(ModelPath.DS.'validation.php');
	require_once(ModelPath.DS.'SessionModel.php');
	require_once(ModelPath.DS.'User.php');
	require_once(ViewPath.DS.'CookieStorage.php');

	class LoginController  {
		// REMINDER: WHEN CREATING MODELS, THE MODEL MIGHT HAVE TO INHERIT FROM THE DATABASE OBJECTS IN THE HELPERS FOLDER?
		private $sessionModel;
		private $loginView;
		private $memberView;
		private $regView;
		private $user;
		private $userModel;
		private $cookie;
		private $username;
		private $passwordSafe;
		private $validation;
		private static $hashString = "sha256";
			

		function __construct () {
			$this->sessionModel = new SessionModel();
			$this->loginView = new LoginView();
			$this->memberView = new MemberView();
			$this->regView = new RegView();
			$this->userModel = new UserModel();
			$this->user = new User($this->getuser(), $this->getSafePassword());
			$this->cookie = new CookieStorage();
			$this->validation = new validation();
		}


		//Get input from register class.
		private function getuser() {
			return $this->regView->GetUserName();
		}

		private function getPassword() {
			return $this->regView->GetPasswordOne();	
		}

		private function getSafePassword() {

			return $this->regView->getSafePassword();
		}

		private function getPasswordTwo() {

			return $this->regView->GetPasswordTwo();
		}

		//Get input from login class.
		private function getUsernameFromLoginView() {

			return $this->loginView->GetUsername();
		}
		private function getPasswordFromLoginView() {

			return $this->loginView->GetPassword();
		}

		private function getWebSiteAndIpAdress(){
 			return $this->loginView->getWebBrowserAndIpAdress();
 		}
	
		//Render login and logut.
		public function RunLoginLogic () {	
			// Set page reload flag
			$onReload = false;

			// Assign needed instances in local variables (Experiment).
			$loginView = clone $this->loginView;		
			$memberView = clone $this->memberView;
			$regView = clone $this->regView;
			$sessionModel = clone $this->sessionModel;
			$usermodel = clone $this->userModel;

			// If user press register a new user , render register form.
			if($loginView->userPressRegNewUser() == true) {
				$regView->RenderRegForm();die();
				return true;
			}	

			// If user press register button , do ....
			if ($regView->DidUserPressReg() == true ) {
					$username = $this->getuser();
					$password = $this->getPassword();
					$passwordTwo = $this->getPasswordTwo();

				if($this->validation->ValidateRegistration($username,$password,$passwordTwo) === true) {
					$getUserName = $this->user->getUsername();
					$userEx = $this->userModel->userEX($getUserName);

					if ($userEx) {
						$usermodel->addNewUser($this->user);
					  	$loginView->RenderLoginForm($loginView->getNewUserSuccessMsg());
					}
					else {
						return $regView->RenderRegForm($this->validation->validateUserIfEX());
					}	
			}
			else {
				return $regView->RenderRegForm($this->validation->ValidateRegistration($username,$password,$passwordTwo));
				}
			
			}	

			// RENDER START PAGE, Render loginView if user is not already logged in and did not press Login Button
			if(!$sessionModel->IsLoggedIn() && !$loginView->UserPressLoginButton()
			 && !$memberView->RememberMe() && !$regView->DidUserPressReg() && !$sessionModel->IsAdminLoggedIn()) {
				// Generate output data
				$loginView->RenderLoginForm();
				return;
			}

			// USER LOGS OUT
			if ($memberView->UserPressLogoutButton()) {	
				$this->LogoutUser();
				return true;
			}

			// USER MAKES A LOGIN REQUEST
			if ($loginView->UserPressLoginButton()) {
				$result = $this->AuthenticateUser();
	
				// If comparison to database succeeded login user and render memberarea.
				if ($result === true) {

					$autoLoginIsSet = $loginView->AutoLoginIsChecked();
					$memberView->RenderMemberArea($autoLoginIsSet, $onReload);		
					return true;
				}
				else {

					// render loginform with errormessage.
					$loginView->RenderLoginForm($result);
				}

			}

				

			// USER IS ALREADY LOGGED IN AND RELOADS PAGE or USER LOGGED IN WITH REMEMBER ME AND RELOADS
			if ($sessionModel->IsLoggedIn() || $memberView->RememberMe() ||
				 $sessionModel->IsAdminLoggedIn() && $sessionModel->IsLoggedIn()){

					$onReload = true;
					$validId = hash(self::$hashString,$this->getWebSiteAndIpAdress());

					if ($sessionModel->IsStolen($validId)) {	
						$this->memberView->LogoutUser();
						$this->loginView->RenderLoginForm();

						return false;
					}
			
				// This if statement only checks the or block if user klicked remember me because of the && - operator.
				if ($memberView->RememberMe() && ($this->UserCredentialManipulated() || $this->CookieDateManipulated())) {
					
					$this->LogoutUser(false);
					return false;
				}
					$memberView->RenderMemberArea(false, $onReload);
					return true;
			}
		}

		// HELPER FUNCTIONS FOR THIS CONTROLLER
		// Authentication logic. 
		public function GetUserCookie(){
			$username = $this->loginView->GetUsername();
			return $this->userModel->getUserCookie($username);
			
		}
		public function AuthenticateUser () {
			$username = $this->getUsernameFromLoginView();
			$password = $this->getPasswordFromLoginView();
			$message = $this->validation->Validate($username,$password);
			

			if ($message !== true) {
				
				return $message;
			}
			
			$username = $this->loginView->GetUsername();
			$userAuthenticated = $this->userModel->AuthenticateUser($username);
			$username = $userAuthenticated[1];
			$password = $userAuthenticated[2];
			$this->AdminID = $userAuthenticated[4];			
			$this->memberView->getSafeId($this->AdminID,$this->getWebSiteAndIpAdress());
			$pass = $this->loginView->GetPassword();
			$final = crypt($pass, $password);
			$cryptId = $this->AdminID;
			$userCookie =  $this->GetUserCookie();
			$usr = $userCookie[1];
			$pws = $userCookie[2];

			if ($final === $password && $userAuthenticated) {

				$this->sessionModel->LoginUser($this->user,$this->getWebSiteAndIpAdress());
				if ($this->loginView->AutoLoginIsChecked()) {
					$cookieTimestamp = time() + 60*60*24*30;
					$this->memberView->SaveUserCredentials($username, $pws, $cookieTimestamp,$cryptId);
					$this->userModel->SaveCookieTimestamp($cookieTimestamp,$this->sessionModel->GetUsername());
				}

				return true;
			}
			else {

				return $this->validation->GetLoginErrorMessage($username);
			}
		}

		protected function UserCredentialManipulated () {

			// COMPARE TO HASHED PASSWORD!
			// TODO: MOVE THIS TO THE VIEW.
			// TODO: Get the cookie values from the view before sending them to AuthenticateUser.
			// execute return below if passwords in database are hased.
			// return !@$this->userModel->AuthenticateUser($_COOKIE['username'], $_COOKIE['password']);
			// execute below if passwords in database are not hashed.
			try {

				$username = $this->memberView->GetCookieUsername();
				$password = $this->memberView->GetCookiePassword();				
			}
			catch (\Exception $e) {
				// Handle error: Something went wrong, could not find cookies, return true so that user is thrown out.
				return true;
			}

			return !@$this->userModel->UserCredentialManipulated($username, $password);
		}

		// try to safe date cookie agianst manipulated.
		protected function CookieDateManipulated () {
			$username = $this->memberView->GetCookieUsername();
			$currentTime = time();
			$cookieExpTime = ($this->userModel->GetCookieDateById($username));

			if ($currentTime > $cookieExpTime) {

				return true;

			}
			return false;
		}

		protected function LogoutUser ($isDefaultLogout = true) {
			$this->memberView->LogoutUser();
			$this->loginView->RenderLogoutView($isDefaultLogout);
		}

	}