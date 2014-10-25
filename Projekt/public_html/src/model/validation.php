<?php

	class validation {

	private $didSubmit;
	private $fileName;
	private $imagestypes;
	private $imgRoot;	

	//static messages for validation.

	//Messages for log in system.
	private static $loginErrorMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 		     <button type="button" class="close" data-dismiss="alert">
  										 <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  									     <strong>Felaktigt användarnamn och/eller lösenord.</strong></div>';

	private static $emptyUsernameErrorMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				    <button type="button" class="close" data-dismiss="alert">
  											    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										        <strong>Användarnamn saknas.</strong></div>';

	private static $emptyPasswordErrorMessage ='<div class="alert alert-danger alert-dismissible" role="alert">
  							 				   <button type="button" class="close" data-dismiss="alert">
  											   <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										       <strong>Lösenord saknas.</strong></div>';

	private static $emptyUernameAndPassword = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				  <button type="button" class="close" data-dismiss="alert">
  											  <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										      <strong>Användarnamn & Lösenord saknas!</strong></div>';

	//Messages for Reg system.
	private static $ErrorUserNameMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				<button type="button" class="close" data-dismiss="alert">
  											<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										    <strong>Användarnamnet har för få tecken. Minst 3 tecken</strong></div>';

	private static $ErrorPasswordMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				<button type="button" class="close" data-dismiss="alert">
  											<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										    <strong>Lösenorden har för få tecken. Minst 6 tecken</strong></div>';

	private static $ErrorDiffrentPasswordMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				       <button type="button" class="close" data-dismiss="alert">
  											       <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										           <strong>Lösenorden matchar inte</strong></div>';

	private static $ErrorHasTagsUsernameMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				       <button type="button" class="close" data-dismiss="alert">
  											       <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										           <strong>Användarnamnet innehåller ogiltiga tecken</strong></div>';

	private static $ErrorUserHasToken = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 		     <button type="button" class="close" data-dismiss="alert">
  										 <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  									     <strong>Användarnamnet är upptaget!</strong></div>';

	private static $ErrorPasswordAndUserNameMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				          <button type="button" class="close" data-dismiss="alert">
  											          <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										              <strong>Användarnamnet har för få tecken. Minst 3 tecken <br>
  										              Lösenorden har för få tecken. Minst 6 tecken</strong></div>';

	//Messages for upload function.
	private static $ErrorUPLOAD_ERR_FORM_SIZE = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				     <button type="button" class="close" data-dismiss="alert">
  											     <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										         <strong>Filen är för stort!!</strong></div>';

	private static $ErrorUPLOAD_ERR_NO_FILE = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				  <button type="button" class="close" data-dismiss="alert">
  											  <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										      <strong>Välj en bild först sen tryck ladda upp!!!</strong></div>';

	private static $ErrorUPLOAD_ERR_NO_TMP_DIR = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 				      <button type="button" class="close" data-dismiss="alert">
  											      <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  										          <strong>Som fel har inträffat</strong></div>';

	//Message for Contact function.
  	private static $ErrorMsgAndEmail = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 		    <button type="button" class="close" data-dismiss="alert">
  									    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  								        <strong>Eposten och meddelandet kan inte vara tom!</strong></div>';										          

	private static $ErrorNameMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 		    <button type="button" class="close" data-dismiss="alert">
  									    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  								        <strong>Namnet var fel formlerat!</strong></div>';

	private static $ErrorEmailMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 	         <button type="button" class="close" data-dismiss="alert">
  							   	         <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  								         <strong>Eposten var fel formlerat!</strong></div>';

	private static $ErrorEmptyMessage = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 			<button type="button" class="close" data-dismiss="alert">
  									    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  							            <strong>Du kan inte skicka en tom meddelande!</strong></div>';

	private static $ErrorEmptyName = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 		 <button type="button" class="close" data-dismiss="alert">
  									 <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  									<strong>Namnet måste anges!</strong></div>';

	private static $ErrorEmptyEmail = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 		   <button type="button" class="close" data-dismiss="alert">
  								       <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  								       <strong>Eposten måste anges!</strong></div>';

	private static $ERRORInput = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 	  <button type="button" class="close" data-dismiss="alert">
  								  <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  							      <strong>Namnet måste anges!<br> Eposten måste anges! <br> Meddelandet kan inte vara tom!</strong></div>';

	private static $ErrorMiniName = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 		 <button type="button" class="close" data-dismiss="alert">
  								     <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  							         <strong>Namet kan inte vara mindre än 3 tecken!</strong></div>';

	private static $ErrorMiniMsg = '<div class="alert alert-danger alert-dismissible" role="alert">
  							 	    <button type="button" class="close" data-dismiss="alert">
  								    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  								    <strong>Meddelandet kan inte vara mindre än tre tecken!</strong></div>';

	//Regex validation.
	private $emailExp;
	private $Exp;

	public function __construct(){
		//Regx took from http://www.phpportalen.net/.
		$this->emailExp = "/^[a-z0-9\å\ä\ö._-]+@[a-z0-9\å\ä\ö.-]+\.[a-z]{2,6}$/i";
		$this->Exp = "/^([a-zA-ZÅÄÖåäö]{2,10})([- ]{1})?([a-zA-ZÅÄÖåäö]{2,10})?$/";

	}

	public function getImgName($upload) {
		$this->fileName = $upload;
	}

	//validation to reistration.
	public function ValidateRegistration ($username,$password,$passwordTwo) {

			var_dump($username != strip_tags($username));

			if (mb_strlen($username) < 3 && mb_strlen($password) < 6) {
				return self::$ErrorPasswordAndUserNameMessage;
			}

		    else if ($username == null || mb_strlen($username) < 3) {
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

			else if($Email == null && $Message == null) {
				return self::$ErrorMsgAndEmail;
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

			else if($Email == null && $Message == null) {
				return self::$ErrorMsgAndEmail;
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

			else if($Email == null && $Message == null) {
				return self::$ErrorMsgAndEmail;
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

			
}