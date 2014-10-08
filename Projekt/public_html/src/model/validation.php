<?php

	class validation {

	//static messages for validation.
	private static $loginErrorMessage = "Felaktigt användarnamn och/eller lösenord.";
	private static $emptyUsernameErrorMessage = "Användarnamn saknas.";
	private static $emptyPasswordErrorMessage = "Lösenord saknas.";	
	private static $ErrorUserNameMessage = "Användarnamnet har för få tecken. Minst 3 tecken";
	private static $ErrorPasswordMessage = "Lösenorden har för få tecken. Minst 6 tecken";
	private static $ErrorDiffrentPasswordMessage = "Lösenorden matchar inte";
	private static $ErrorHasTagsUsernameMessage = "Användarnamnet innehåller ogiltiga tecken";
	private static $ErrorUserHasToken = "Användarnamnet är upptaget!";
	private static $ErrorPasswordAndUserNameMessage = "Användarnamnet har för få tecken. Minst 3 tecken <br> Lösenorden har för få tecken. Minst 6 tecken";
	private $didSubmit;
	private $fileName;
	private $imagestypes;
	private $imgRoot;
	private static $ErrorUPLOAD_ERR_FORM_SIZE = "Filen är för stort!!";
	private static $ErrorUPLOAD_ERR_NO_FILE = "Välj en bild först sen tryck ladda upp!!!";
	private static $ErrorUPLOAD_ERR_NO_TMP_DIR = "Som fel har inträffat";



	public function __construct(){

	}

	public function getImgName($upload) {
		$this->fileName = $upload;
	}

	//validation to reistration.
	public function ValidateRegistration ($username,$password,$passwordTwo) {

			if (mb_strlen($username) < 3 && mb_strlen($password) < 6) {
				return self::$ErrorPasswordAndUserNameMessage;
			}

		    if ($username == null || mb_strlen($username) < 3) {

				return self::$ErrorUserNameMessage;
			}
			
			else if ($password == null || mb_strlen($password) < 6) {
		
				return self::$ErrorPasswordMessage;
			}
			else if ($passwordTwo == null || mb_strlen($passwordTwo) < 6) {
		
				return self::$ErrorPasswordMessage;
			}
			else  if($username != strip_tags($username)) {

				return self::$ErrorHasTagsUsernameMessage;
			}	
			else if($password != $passwordTwo) {

				return self::$ErrorDiffrentPasswordMessage;
			}		
				return true;	
		}

		//validation to log in system.
		public function Validate ($username,$password) {
			if ($username == null) {

				return self::$emptyUsernameErrorMessage;
			}

			else if ($password == null) {

				$_SESSION['LoginValues']['username'] = $username;

				return self::$emptyPasswordErrorMessage;
			}

			return true;
		}

		//validation to log in system.
		public function GetLoginErrorMessage ($username) {

			$_SESSION['LoginValues']['username'] = $username;

			return self::$loginErrorMessage;
		}

		public function validateUserIfEX() {
			return self::$ErrorUserHasToken;
		}

		public function hasSubmitToUpload($hasSubmit) {
			$this->didSubmit = $hasSubmit; 
		}

		public function getFileName($upload) {
			$this->fileName = $upload;
		}

		public function getImgRoot($imgPath) {
			$this->imgRoot = $imgPath;
		}
		

		public function errorToMessage() {


				 if($_FILES[$this->fileName]['error'] == 3) {
					# code...
					if (file_exists($this->imgRoot . $_FILES[$this->fileName]['name'])) {
							# code...
						//Remove the wrong file that is not completed.
						unlink($this->imgRoot . $_FILES[$this->fileName]['name']);
					}	
					return self::$ErrorUPLOAD_ERR_NO_TMP_DIR;
				 }
		
			     else if($_FILES[$this->fileName]['error'] == 2 || $_FILES[$this->fileName]['error'] == 1) {
						# code...
						return self::$ErrorUPLOAD_ERR_FORM_SIZE;
					}

			      else if($_FILES[$this->fileName]['error'] == 4) {
				    	# code...
				     	return self::$ErrorUPLOAD_ERR_NO_FILE;
				   }
			
		}
			
}