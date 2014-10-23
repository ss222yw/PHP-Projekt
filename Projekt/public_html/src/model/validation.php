<?php

	class validation {

	private $didSubmit;
	private $fileName;
	private $imagestypes;
	private $imgRoot;	

	//static messages for validation.

	//Messages for log in system.
	private static $loginErrorMessage = "<p class='text-danger'>Felaktigt användarnamn och/eller lösenord.</p><br>";
	private static $emptyUsernameErrorMessage = "<p class='text-danger'>Användarnamn saknas.</p><br>";
	private static $emptyPasswordErrorMessage = "<p class='text-danger'>Lösenord saknas.</p><br>";	
	private static $emptyUernameAndPassword = "<p class='text-danger'>Användarnamn & Lösenord saknas!</p><br>";

	//Messages for Reg system.
	private static $ErrorUserNameMessage = "<p class='text-danger'>Användarnamnet har för få tecken. Minst 3 tecken</p><br>";
	private static $ErrorPasswordMessage = "<p class='text-danger'>Lösenorden har för få tecken. Minst 6 tecken</p><br>";
	private static $ErrorDiffrentPasswordMessage = "<p class='text-danger'>Lösenorden matchar inte</p><br>";
	private static $ErrorHasTagsUsernameMessage = "<p class='text-danger'>Användarnamnet innehåller ogiltiga tecken</p><br>";
	private static $ErrorUserHasToken = "<p class='text-warning'>Användarnamnet är upptaget!</p><br>";
	private static $ErrorPasswordAndUserNameMessage = "<p class='text-danger'>Användarnamnet har för få tecken. Minst 3 tecken <br> Lösenorden har för få tecken. Minst 6 tecken</p><br>";

	//Messages for upload function.
	private static $ErrorUPLOAD_ERR_FORM_SIZE = "<p class='bg-danger'>Filen är för stort!!</p><br>";
	private static $ErrorUPLOAD_ERR_NO_FILE = "<p class='bg-danger'>Välj en bild först sen tryck ladda upp!!!</p><br><br>";
	private static $ErrorUPLOAD_ERR_NO_TMP_DIR = "<p class='bg-danger'>Som fel har inträffat</p><br>";

	//Message for Contact function.
	private static $ErrorNameMessage = "<p class='bg-danger'>Namnet var fel formlerat!</p><br>";
	private static $ErrorEmailMessage = "<p class='bg-danger'>Eposten var fel formlerat!</p><br>";
	private static $ErrorEmptyMessage = "<p class='bg-danger'>Du kan inte skicka en tom meddelande!</p><br>";
	private static $ErrorEmptyName = "<p class='bg-danger'>Namnet måste anges!</p><br>";
	private static $ErrorEmptyEmail = "<p class='bg-danger'>Eposten måste anges!</p><br>";
	private static $ERRORInput = "<p class='bg-danger'>Namnet måste anges!<br> Eposten måste anges! <br> Meddelandet kan inte vara tom!</p><br>";
	private static $ErrorMiniName ="<p class='bg-danger'>Namet kan inte vara mindre än 3 tecken!</p><br>";
	private static $ErrorMiniMsg = "<p class='bg-danger'>Meddelandet kan inte vara mindre än tre tecken!</p><br>";
	private static $ErrorTel = "<p class='bg-danger'>Telefon Nummer består av siffror!Ingen bokstav tilllåtet.</p><br>";
	private static $ErrorAprtNr = "<p class='bg-danger'>Lägenhetens nummer består av siffror!Ingen bokstav tilllåtet.</p><br>";

	//Regex validation.
	private $emailExp;
	private $Exp;
	private $NrExp;

	public function __construct(){
		//Regx took from http://www.phpportalen.net/.
		$this->emailExp = "/^[a-z0-9\å\ä\ö._-]+@[a-z0-9\å\ä\ö.-]+\.[a-z]{2,6}$/i";
		$this->Exp = "/^([a-zA-ZÅÄÖåäö]{2,10})([- ]{1})?([a-zA-ZÅÄÖåäö]{2,10})?$/";
		$this->NrExp = "/^[0-9]+$/";

	}

	// public function getImgName($upload) {
	// 	$this->fileName = $upload;
	// }

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

		//validation for log in system.
		public function Validate ($username,$password) {
			if ($username == null && $password == null) {
				# code...
				return self::$emptyUernameAndPassword;
			}

			else if ($username == null) {
				return self::$emptyUsernameErrorMessage;
			}

			else if ($password == null) {
				return self::$emptyPasswordErrorMessage;
			}

			return true;
		}


		//Get error login messages.
		public function GetLoginErrorMessage ($username) {
			return self::$loginErrorMessage;
		}

		// return error massage that the name is tooken already.
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
			//error message 3 is the file is uploaded but not complete.
		 if($_FILES[$this->fileName]['error'] == 3) {
			if (file_exists($this->imgRoot . $_FILES[$this->fileName]['name'])) {
				//Remove the wrong file that is not completed.
				unlink($this->imgRoot . $_FILES[$this->fileName]['name']);
			}	
			return self::$ErrorUPLOAD_ERR_NO_TMP_DIR;
		 }
			// error message 2 & 3 for the file is big or the file length is bigger than is php ini supported.
	     else if($_FILES[$this->fileName]['error'] == 2 || $_FILES[$this->fileName]['error'] == 1) {
				return self::$ErrorUPLOAD_ERR_FORM_SIZE;
			}
			// error file 4 is that the user trying to upload widthout file.
	      else if($_FILES[$this->fileName]['error'] == 4) {
		     	return self::$ErrorUPLOAD_ERR_NO_FILE;
		   }
	
     	}


     	//Validation for contact form.
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

		//Validation for interest form.
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

			else if ($Message != strip_tags($Message)) {
				return self::$ErrorHasTagsUsernameMessage;
			}

			else if(!preg_match($this->Exp, $Name)) {
				return self::$ErrorNameMessage;
			}

			else if(!preg_match($this->emailExp, $Email)) {
				return self::$ErrorEmailMessage;
			}	
				
				return true;
		}

		//validation for service form.
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

			else if ($Message != strip_tags($Message)) {
				return self::$ErrorHasTagsUsernameMessage;
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