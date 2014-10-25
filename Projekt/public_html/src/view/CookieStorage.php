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
		private static $cookieMsg = "msg";
		
		public function __construct() {
			
		}

		public function SaveUserCredentials ($username, $password, $cookieTimestamp,$safeId) {
			$newPassword = $password.$safeId;
			setcookie(self::$usernameCookie, $username, $cookieTimestamp, "/");
			setcookie(self::$passwordCookie, $newPassword, $cookieTimestamp, "/");
		}

 
		public function DeleteUserCredentials () {
			setcookie(self::$usernameCookie, "", 1, "/");
			setcookie(self::$passwordCookie, "", 1, "/");
		}

		public function SaveMessageCookie($Message) {
			setcookie(self::$cookieMsg, $Message, time() + 60, "/");
		}

		public function DeleteMessageCookie() {
			setcookie(self::$cookieMsg, "", 1, "/");
		}

		public function GetMessageCookie() {
			if(isset($_COOKIE[self::$cookieMsg])) {
				return $_COOKIE[self::$cookieMsg];
			}
		}

		public function RememberMe () {

			return isset($_COOKIE[self::$usernameCookie]);
		}

		public function GetCookieUsername () {

			if (isset($_COOKIE[self::$usernameCookie])) {
				
				return $_COOKIE[self::$usernameCookie];
			}
		
		}

		public function GetAdminSafeID() {
			if (isset($_COOKIE[self::$admin])) {
				return $_COOKIE[self::$admin];
			}
		}

		public function GetCookiePassword () {

			if (isset($_COOKIE[self::$passwordCookie])) {
				
				return $_COOKIE[self::$passwordCookie];
			}
			
		}		
	}