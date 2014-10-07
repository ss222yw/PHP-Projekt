<?php
	class SessionModel {

			private $isLoggedIn = false;
			private $isAdminLoggedIn = false;
			private $userId;
			private $message;
			private static $sessionUserId = 'userId';
			private static $sessionUserHeadCategory = 'userdata';
			private static $sessionUsername = 'username';
			private static $sessionPassword = 'password';
			private static $sessionAdmin = 'AdminLogin';
			private static $securitySessionName = 'unique';
			private static $hashString = "sha256";
			private $userModel;
			private $safID;

		function __construct () {
				$this->userModel = new UserModel();
			if (!isset($_SESSION[self::$sessionUserHeadCategory])) {
				
				$_SESSION[self::$sessionUserHeadCategory][self::$sessionUsername] = '';
			}
		}

		public function IsAdminLoggedIn() {
			return isset($_SESSION[self::$sessionAdmin]);
		}

		public function IsLoggedIn () {
			return isset($_SESSION[self::$sessionUsername]);
		}

		public function GetUserId () {
			return $this->username;
		}

		public function GetUsername () {
			return $_SESSION[self::$sessionUserHeadCategory][self::$sessionUsername];
		}

		public function LoginAdmin($safeId) {
			global $remote_ip;
			global $user_agent;
				if ($safeId == 1) {
				# code...
				$_SESSION[self::$sessionAdmin] = $safeId;
				$_SESSION[self::$securitySessionName] = hash(self::$hashString, $remote_ip . $user_agent);
				$this->isAdminLoggedIn = true;
			}
			else {
					if ($safeId != 1) {
					# code...
						unset($_SESSION[self::$sessionAdmin]);

					}

			}
			
		}




		public function LoginUser (User $user) {
			global $remote_ip;
			global $user_agent;
			// session_set_cookie_params(0);
		
				$this->username = $_SESSION[self::$sessionUsername] = $user->getUsername();
				$_SESSION[self::$sessionUserHeadCategory][self::$sessionUsername] = $user->getUsername();
				$_SESSION[self::$securitySessionName] = hash(self::$hashString, $remote_ip . $user_agent);
				$this->isLoggedIn = true;
			
	    	
		}

		public function LogoutUser () {
			unset($_SESSION[self::$sessionUsername]);
			unset($_SESSION[self::$sessionAdmin]);
			$this->isLoggedIn = false;
			$this->isAdminLoggedIn = false;
		}

		public function IsStolen ($validId) {
			return isset($_SESSION[self::$securitySessionName]) && $validId != $_SESSION[self::$securitySessionName];
		}
	}