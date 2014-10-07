<?php

	class CookieStorage {

		public $username;
		public $password;
		private $safe;
		private static $usernameCookie = "username";
		private static $passwordCookie = "password";
		private static $admin = "hash";
		private static $cookieUsernameErrMsg = 'CookieUsername does not exist!';
		private static $cookiePasswordErrMsg = 'CookiePassword does not exist!';
		
		public function __construct() {
			$this->safe = new safe();
		}

		public function SaveUserCredentials ($username, $password, $cookieTimestamp,$safeId) {
			setcookie(self::$usernameCookie, $username, $cookieTimestamp, "/");
			setcookie(self::$passwordCookie, $password, $cookieTimestamp, "/");
			if ($safeId == 1) {
				# code...
				$hashedID = $this->safe->create_hash($safeId);
				setcookie(self::$admin, $hashedID , $cookieTimestamp, "/");
			}
			
		
		}


		public function DeleteUserCredentials () {

			setcookie(self::$usernameCookie, "", 1, "/");
			setcookie(self::$passwordCookie, "", 1, "/");
			setcookie(self::$admin,"", 1, "/");
		}

		public function RememberMe () {

			return isset($_COOKIE[self::$usernameCookie]);
		}

		public function RememberMeAdmin () {

			return isset($_COOKIE[self::$admin]);
		}

		public function GetCookieUsername () {

			if (isset($_COOKIE[self::$usernameCookie])) {
				
				return $_COOKIE[self::$usernameCookie];
			}
		

		}

		public function GetCookiePassword () {

			if (isset($_COOKIE[self::$passwordCookie])) {
				
				return $_COOKIE[self::$passwordCookie];
			}
			
		}		
	}