<?php

	class validation {

	private $didSubmit;
	private $fileName;
	private $imagestypes;
	private $imgRoot;	

	//static messages for validation.

	//Messages for log in system.
	private static $loginErrorMessage = "Felaktigt användarnamn och/eller lösenord.";
	private static $emptyUsernameErrorMessage = "Användarnamn saknas.";
	private static $emptyPasswordErrorMessage = "Lösenord saknas.";	
	private static $ErrorUserNameMessage = "Användarnamnet har för få tecken. Minst 3 tecken";
	private static $ErrorPasswordMessage = "Lösenorden har för få tecken. Minst 6 tecken";
	private static $ErrorDiffrentPasswordMessage = "Lösenorden matchar inte";
	private static $ErrorHasTagsUsernameMessage = "Användarnamnet innehåller ogiltiga tecken";
	private static $ErrorUserHasToken = "Användarnamnet är upptaget!";
	private static $ErrorPasswordAndUserNameMessage = "Användarnamnet har för få tecken. Minst 3 tecken <br> Lösenorden har för få tecken. Minst 6 tecken";

	//Messages for upload function.
	private static $ErrorUPLOAD_ERR_FORM_SIZE = "Filen är för stort!!";
	private static $ErrorUPLOAD_ERR_NO_FILE = "Välj en bild först sen tryck ladda upp!!!";
	private static $ErrorUPLOAD_ERR_NO_TMP_DIR = "Som fel har inträffat";

	//Message for Contact function.
	private static $ErrorNameMessage = "Namnet var fel formlerat!";
	private static $ErrorEmailMessage = "Eposten var fel formlerat!";
	private static $ErrorEmptyMessage = "Du kan inte skicka en tom meddelande!";
	private static $ErrorEmptyName = "Namnet måste anges!";
	private static $ErrorEmptyEmail = "Eposten måste anges!";
	private static $ERRORInput = "Namnet måste anges!<br> Eposten måste anges! <br> Meddelandet kan inte vara tom!";
	private static $ErrorMiniName ="Namet kan inte vara mindre än 3 tecken!";
	private static $ErrorMiniMsg = "Meddelandet kan inte vara mindre än tre tecken!";
	private static $ErrorTel = "Telefon Nummer består av siffror!Ingen bokstav tilllåtet.";
	private static $ErrorAprtNr = "Lägenhetens nummer består av siffror!Ingen bokstav tilllåtet.";

	private $emailExp;
	private $Exp;
	private $NrExp;

	public function __construct(){

		$this->emailExp = "/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/";
		$this->Exp = "/^[A-Za-z .'-]+$/";
		$this->NrExp = "/^[0-9]+$/";

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
			if (file_exists($this->imgRoot . $_FILES[$this->fileName]['name'])) {
				//Remove the wrong file that is not completed.
				unlink($this->imgRoot . $_FILES[$this->fileName]['name']);
			}	
			return self::$ErrorUPLOAD_ERR_NO_TMP_DIR;
		 }
		
	     else if($_FILES[$this->fileName]['error'] == 2 || $_FILES[$this->fileName]['error'] == 1) {
				return self::$ErrorUPLOAD_ERR_FORM_SIZE;
			}

	      else if($_FILES[$this->fileName]['error'] == 4) {
		     	return self::$ErrorUPLOAD_ERR_NO_FILE;
		   }	
     	}


		public function ContactFormValidation($Name,$Email,$Message) {

			if ($Name == null && $Email == null && $Message == null) {
				return self::$ERRORInput;
			}

		   else if ($Name == null) {
				return self::$ErrorEmptyName;
			}

			else if (mb_strlen($Name) < 3) {
				return self::$ErrorMiniName;
			}

			else if ($Email == null) {
				return self::$ErrorEmptyEmail;
			}

			else if ($Message == null) {
				return self::$ErrorEmptyMessage;
			}

			else if (mb_strlen($Message) < 3) {
				return self::$ErrorMiniMsg;
			}

			else if(!preg_match($this->Exp, $Name)) {
				return self::$ErrorNameMessage;
			}

			else if(!preg_match($this->emailExp, $Email)) {
				return self::$ErrorEmailMessage;
			}	
				
				return true;
		}


		public function InterestFormValidation($Name,$Email,$Message) {

			if ($Name == null && $Email == null && $Message == null) {
				return self::$ERRORInput;
			}

		   else if ($Name == null) {
				return self::$ErrorEmptyName;
			}

			else if (mb_strlen($Name) < 3) {
				return self::$ErrorMiniName;
			}
			else if ($Email == null) {
				return self::$ErrorEmptyEmail;
			}

			else if ($Message == null) {
				return self::$ErrorEmptyMessage;
			}

			else if(mb_strlen($Message) < 3) {
				return self::$ErrorMiniMsg;
			}

			else if(!preg_match($this->Exp, $Name)) {
				return self::$ErrorNameMessage;
			}

			else if(!preg_match($this->emailExp, $Email)) {
				return self::$ErrorEmailMessage;
			}	
				
				return true;
		}


		public function ServiceFormValidation($Name,$Email,$Message,$TEL,$AprtNr) {

			if ($Name == null && $Email == null && $Message == null) {
				return self::$ERRORInput;
			}

		    else if ($Name == null) {
				return self::$ErrorEmptyName;
			}

			else if (mb_strlen($Name) < 3) {
				return self::$ErrorMiniName;
			}
			else if ($Email == null) {
				return self::$ErrorEmptyEmail;
			}

			else if ($Message == null) {
				return self::$ErrorEmptyMessage;
			}

			else if(mb_strlen($Message) < 3) {
				return self::$ErrorMiniMsg;
			}

			else if(!preg_match($this->Exp, $Name)) {
				return self::$ErrorNameMessage;
			}

			else if(!preg_match($this->emailExp, $Email)) {
				return self::$ErrorEmailMessage;
			}	

			else if ($AprtNr != null && !preg_match($this->NrExp,$AprtNr)) {
				return self::$ErrorAprtNr;
			}

			else if ($TEL != null && !preg_match($this->NrExp,$TEL)) {
				return self::$ErrorTel;
			}
				
				return true;
		}

			
}