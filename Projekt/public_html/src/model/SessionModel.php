<?php

	//the require once here just to show the coupling between classes.	
	require_once(ModelPath.DS.'UserModel.php');
	
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


		public function __construct () {
			$this->userModel = new UserModel();
			if (!isset($_SESSION[self::$sessionUserHeadCategory])) {
				
				$_SESSION[self::$sessionUserHeadCategory][self::$sessionUsername] = '';
			}
			@session_start();
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

		public function LoginAdmin($safeId,$web) {
		
				if ($safeId == 1) {
				$_SESSION[self::$sessionAdmin] = $safeId;
				$_SESSION[self::$securitySessionName] = hash(self::$hashString,$web);
				$this->isAdminLoggedIn = true;
			}
			else {
					if ($safeId != 1) {
						unset($_SESSION[self::$sessionAdmin]);
					}

			}
			
		}


		public function LoginUser (User $user,$web) {

				$this->username = $_SESSION[self::$sessionUsername] = $user->getUsername();
				$_SESSION[self::$sessionUserHeadCategory][self::$sessionUsername] = $user->getUsername();
				$_SESSION[self::$securitySessionName] = hash(self::$hashString,$web);
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