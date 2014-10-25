<?php
	//the require once here just to show the coupling between classes.	
	require_once(HelperPath.DS.'HTMLView.php');
	require_once(ViewPath.DS.'RegView.php');

	class LoginView {
		private static $newUserSuccessMsg = '<div class="alert alert-success alert-dismissible" role="alert">
  							 				 <button type="button" class="close" data-dismiss="alert">
  									         <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  									         <strong>Registrering av ny användare lyckades.</strong></div><br><br>';

		private static $logOutSuccessMessage = '<div class="alert alert-success alert-dismissible" role="alert">
  							 				    <button type="button" class="close" data-dismiss="alert">
  											    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										        <strong>Du är nu utloggad.</strong></div><br><br>';

		private static $corruptCookieLogoutMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				          <button type="button" class="close" data-dismiss="alert">
  											          <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										              <strong>Fel information i cookie.</strong></div><br><br>';


		private $mainView;
		private $regView;
		private $safe;
		private $remote_ip;
		private $user_agent;
		private $username = "username";
		private $password = "password";
		private $rememberMe = "rememberMe";
		private $submit = "submit";
 
		function __construct () {

			$this->mainView = new HTMLView();
			$this->regView = new RegView();
			$this->safe = new safe();
			$this->remote_ip = $_SERVER['REMOTE_ADDR'];
			$this->user_agent = $_SERVER['HTTP_USER_AGENT'];
		}		

		public function getWebBrowserAndIpAdress(){
			return $this->remote_ip.$this->user_agent;
		}

		public function getSafeInputPassword() {
			return $this->safe->create_hash($this->GetUsername());	
		}
		public function getNewUserSuccessMsg() {
			return self::$newUserSuccessMsg;
		}

		public function GetLoginFormHTML ($message = '') {

			// IF cookie with errors is set render a sertain view.
			$responseMessages = '';

			if ($message != '') {
					
				$responseMessages .= '<strong>' . $message . '</strong>';
			}

			$loginHTML = 
			'<br>'.
			'<form id="upload" class="form-inline" enctype="multipart/form-data" method="post" action="">' .
					$responseMessages .
					'<input type="text" name="'.$this->username.'" class="form-control" placeholder="Användarnamn" value="' . $this->GetUsername() . '" maxlength="30" id="username" /> ' .
					'<input type="password" name="'.$this->password.'" class="form-control" placeholder="Lösenord" maxlength="30" id="password" /> ' .
					'<label for="rememberMe">Håll mig inloggad </label>&nbsp;&nbsp;'.
					'<input id="rememberMe" type="checkbox" name="'.$this->rememberMe.'">&nbsp;&nbsp;'.
		 			'<input type="submit" name="'.$this->submit.'" id="submit" value="Logga in" class="btn btn-primary " />'.
					'<br>'.
					'<br>'.
					'&nbsp;&nbsp;&nbsp;&nbsp;Ingen konto? <a href="?registrera" name="registrera">Registrera dig här</a>'.
			'</form>';

			$_SESSION['LoginValues'][$this->username] = "";

			return $loginHTML;			
		}	

		public function RenderLoginForm ($errorMessage = '') {

			$loginHTML = $this->GetLoginFormHTML($errorMessage);
			echo $this->mainView->echoHTML($loginHTML);
		}

		public function RenderLogoutView ($isDefaultLogout = true) {

			$isDefaultLogout ? $this->RenderLoginForm(self::$logOutSuccessMessage)
		 					 : $this->RenderLoginForm(self::$corruptCookieLogoutMessage);
							

		}

		public function GetUsername () {

			// Is called from LoginController
			if (isset($_POST[$this->username])) {
				
				return $_POST[$this->username];
			}
		}

		public function GetPassword () {

			// Is called from LoginController
			if (isset($_POST[$this->password])) {
				
				return $_POST[$this->password];
			}
		}

		public function UserPressLoginButton () {

			return isset($_POST[$this->submit]);
		}


		public function AutoLoginIsChecked () {

			$isChecked = false;

			if (isset($_POST[$this->rememberMe])) {
				
				$isChecked = $_POST[$this->rememberMe];
			}

			return ($isChecked == 'true' || $isChecked == 'on') ? true : false;
		}


		public function userPressRegNewUser(){
			if (isset($_GET['registrera'])) {
				return true;
			}
			
		}
	}