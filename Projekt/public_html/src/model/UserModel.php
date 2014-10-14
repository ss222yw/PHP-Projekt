<?php
	require_once(HelperPath.DS.'Database.php');

	class UserModel extends Database {
		
		private static $username = 'username';
	    private static $password = 'password';
		private static $autologin = "autologin";
		private static $AdminId = 'AdminId';

		// UNCOMMENTED FAKE AUTHENTICATION DATA
			public function __construct () {
				$this->tabel = "user";
			}

		
		//Get all from tabel name where username = login input username.
		public function AuthenticateUser($username) {
		
			try {
				
				$pdo = $this->connectionToDataBase();
				$sql = "SELECT * from $this->tabel 
				WHERE BINARY ". self::$username ." = ?";
				$params = array($username);
				$query = $pdo->prepare($sql);
				$query->execute($params);
				$result = $query->fetch();
				return $result;

			}catch(PDOException $ex) {

				die('An unknown error hase happened');
			}
		}

		// Add a new user from reg to tabel name to username and password.
		public function addNewUser(User $user) {

			try {

				$pdo = $this->connectionToDataBase();

				$sql = "INSERT INTO $this->tabel    
				(" . self::$username . ", " . self::$password . ")
				VALUES(?,?)";

				$params = array($user->getUsername(), $user->getPasswrod());

				$query = $pdo->prepare($sql);

				$query->execute($params);

			}catch(PDOException $ex) {

				die('An unknown error has happened');
			}

		}

		// Make sure that the username is not has been add before.
		public function userEX($username) {
			try {

			$pdo = $this->connectionToDataBase();
			$sql ="SELECT COUNT(*) AS count 
			FROM $this->tabel  WHERE username=?";
			$params = array($username);
			$query = $pdo->prepare($sql);
			$query->execute($params);

			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
  			$count = $row["count"];
			}
			if ($count > 0) {
  			return false;
			}
			return true;
				
			} catch (Exception $e) {

				
			die('An unknown error has happened');	
				
			}
		
		}		

		// Save cookie time to database.
		public function SaveCookieTimestamp ($timestamp, $username) {

			try {
			$newData = new UserModel();			
			$pdo = $newData->connectionToDataBase();
			$sql = "UPDATE $this->tabel
			SET  autologin  = ?
			WHERE  username = ?";
			$params = array($timestamp, $username);
			$query = $pdo->prepare($sql);
			$query->execute($params);

			}
			catch(PDOException $ex) {
				die('An unknown error has happened');
			}
	
		}

		// Get Cookie time by username.
		public function GetCookieDateById ($username) {

		try {

			$pdo = $this->connectionToDataBase();
			$sql = "SELECT autologin
			FROM $this->tabel
			WHERE    username =?";
			$params = array($username);
			$query = $pdo->prepare($sql);
			$query->execute($params);
			$result = $query->fetch();
			$timestamp = array_shift($result);	
			return $timestamp;
			}
			catch(PDOException $ex){
				die('An unknown error has happened');
			}
			
		}

			//Get all from tabel name where username = login input username.
			public function getUser($username) {
			
			try {
				
				$newData = new UserModel();			
				$pdo = $newData->connectionToDataBase();
				$sql = "SELECT * from $this->tabel 
				WHERE BINARY ". self::$username ." = ?";
				$params = array($username);
				$query = $pdo->prepare($sql);
				$query->execute($params);
				$result = $query->fetch();
				return $result;

			}catch(PDOException $ex) {

				die('An unknown error hase happened');
			}
		}

			//Get all from tabel name where username = login input username.
			public function getUserCookie($username) {
		
			try {
				
				$newData = new UserModel();			
				$pdo = $newData->connectionToDataBase();
				$sql = "SELECT * from $this->tabel 
				WHERE BINARY ". self::$username ." = ?";
				$params = array($username);
				$query = $pdo->prepare($sql);
				$query->execute($params);
				$result = $query->fetch();
				return $result;

			}catch(PDOException $ex) {

				die('An unknown error hase happened');
			}
		}

		//Make sure that the username and password in cookies is coorect!
		public function UserCredentialManipulated ($username, $data) {
			$ArrayUser = $this->getUser($username);
			$u = $ArrayUser[1];
			$hp = $ArrayUser[2];
			return ($u === $username && $hp === $data);
		}


		
	}

