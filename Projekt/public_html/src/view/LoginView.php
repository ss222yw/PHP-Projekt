<?php

	require_once(HelperPath.DS.'HTMLView.php');

	class LoginView {
		private static $newUserSuccessMsg = '<p class="text-success">Registrering av ny användare lyckades.</p><br>';
		private static $logOutSuccessMessage = "<p class='text-success'>Du är nu utloggad.</p><br>";
		private static $corruptCookieLogoutMessage = "<p class='text-danger'>Fel information i cookie.</p><br>";
		private $mainView;
		private $regView;
		private $safe;
		private $remote_ip;
		private $user_agent;
 
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
			'<form id="upload" class="form-horizontal" enctype="multipart/form-data" method="post" action="">' .
					'<legend>Login - Skriv in användarnamn och lösenord</legend>' .
					$responseMessages .
					'<div class="form-group">'.
					'<div class="col-xs-8">'.
					'<label for="username">Användarnamn: </label>' .
					'<input type="text" name="username" class="form-control" placeholder="Användarnamn" value="' . $this->GetUsername() . '" maxlength="30" id="username" /> ' .
					'</div>'.
					'</div>'.
					'<div class="form-group">'.
					'<div class="col-xs-8" >'.
					'<label for="password">Lösenord: </label>' .
					'<input type="password" name="password" class="form-control" placeholder="Lösenord" maxlength="30" id="password" /> ' .
					'</div>'.
					'</div>'.
					'<label for="rememberMe">Håll mig inloggad :</label>'.
					'<input id="rememberMe" type="checkbox" name="rememberMe">'.
		 			'<input type="submit" name="submit" id="submit" value="Logga in" class="btn btn-primary " />'.
					'<br>'.
					'<br>'.
					'<a href="?registrera" name="registrera">Registrera dig</a>'.
			'</form>';

			$_SESSION['LoginValues']['username'] = "";

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
			if (isset($_POST['username'])) {
				
				return htmlentities($_POST['username']);
			}
		}

		public function GetPassword () {

			// Is called from LoginController
			if (isset($_POST['password'])) {
				
				return htmlentities($_POST['password']);
			}
		}

		public function UserPressLoginButton () {

			return isset($_POST['submit']);
		}


		public function AutoLoginIsChecked () {

			$isChecked = false;

			if (isset($_POST['rememberMe'])) {
				
				$isChecked = $_POST['rememberMe'];
			}

			return ($isChecked == 'true' || $isChecked == 'on') ? true : false;
		}


		public function userPressRegNewUser(){
			if (isset($_GET['registrera'])) {
				return true;
			}
			
		}
	}