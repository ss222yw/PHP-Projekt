<?php 
	require_once(HelperPath.DS.'HTMLView.php');
	require_once(ViewPath.DS.'CookieStorage.php');

	Class MemberView {

		private $cookieStorage;
		private $mainView;
		private $sessionModel;
		private $safeID;
		private static $defaultLoginSuccessMessage = "<p class='text-success'>Inloggning lyckades.</p><br>";
		private static $autoLoginSuccessMessage = "<p class='text-success'>Inloggning lyckades och vi kommer ihåg dig nästa gång.</p><br>";
		private static $cookieLoginSuccessMessage = "";
		private static $cookieUsernameErrMsg = 'CookieUsername does not exist!';
		private static $cookiePasswordErrMsg = 'CookiePassword does not exist!';
		private static $superGlobalGetValue = 'login';
		private static $sessionUserHeadCategory = 'userdata';
		private static $sessionUsername = 'username';
		

		function __construct () {

			$this->mainView = new HTMLView();
			$this->cookieStorage = new CookieStorage();
			$this->sessionModel = new SessionModel();
		}


		public function GetMemberStartHTML ($message = '') {

			$successMessage = isset($_GET[self::$superGlobalGetValue]) ? '<strong>' . $message . '</strong>' : "";
			$username = '';

			if (isset($_SESSION[self::$sessionUserHeadCategory][self::$sessionUsername])) {
				
				$username = $_SESSION[self::$sessionUserHeadCategory][self::$sessionUsername];
			}
			
			if (isset($_COOKIE[self::$sessionUsername])) {

				$username = $_COOKIE[self::$sessionUsername];
			}

			$memberHTML = '<div id="memberView">'.
						'<form id="logout" enctype="multipart/form-data" method="post" action="">'.
						'<fieldset class="memberView">' .
							'<h2>' . $username . ' är inloggad.</h2>' .
							$successMessage .
						
						//'<a href="?logout">Logga ut<a/>'.
						'<input type="submit" name="logout" id="submit" value="Logga ut" class="btn btn-primary"/>'.
						'</fieldset>'.
							'</div>'.
							'</form>';

			return $memberHTML;
		}

		public function RenderMemberArea ($autoLoginIsSet, $onReload) {

			if ($onReload) {

				$memberHTML = $this->GetMemberStartHTML(self::$cookieLoginSuccessMessage);
			
				if ($this->sessionModel->isLoggedIn()) {

					$memberHTML = $this->GetMemberStartHTML();
				}
			}
			else {

				$memberHTML = $this->GetMemberStartHTML(self::$defaultLoginSuccessMessage);

				if ($autoLoginIsSet) {

					$memberHTML = $this->GetMemberStartHTML(self::$autoLoginSuccessMessage);
				}
			}

			echo $this->mainView->echoHTML($memberHTML);
		}

		public function UserPressLogoutButton () {

			if (isset($_POST['logout'])) {

				return true;
			}
		}

		public function SaveUserCredentials ($username, $password, $cookieTimestamp,$cryptId) {

			$this->cookieStorage->SaveUserCredentials($username, $password, $cookieTimestamp,$cryptId);
		}

		public function DeleteUserCredentials() {

			$this->cookieStorage->DeleteUserCredentials();
		}

		public function RememberMe() {

			return $this->cookieStorage->RememberMe();
		}

		public function getSafeId($safeId,$web) {
			$this->sessionModel->LoginAdmin($safeId,$web);

		}

		public function GetCookieUsername() {

			try {

				return $this->cookieStorage->GetCookieUsername();
			}
			catch (\Exception $e) {

				throw new \Exception(self::$cookieUsernameErrMsg);
			}
		}

		public function GetCookiePassword() {

			try {

				return $this->cookieStorage->GetCookiePassword();
			}
			catch (\Exception $e) {

				throw new \Exception(self::$cookiePasswordErrMsg);
			}
		}

		public function LogoutUser () {

			// Remove cookies if remember me.
			if ($this->RememberMe()) {
				
				$this->DeleteUserCredentials();
			}

			// Logout user and render loginView.
			$this->sessionModel->LogoutUser();
		}		

	}