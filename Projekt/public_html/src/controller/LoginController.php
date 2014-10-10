<?php

	require_once(ModelPath.DS.'UserModel.php');
	require_once(HelperPath.DS.'HTMLView.php');
	require_once(ViewPath.DS.'LoginView.php');
	require_once(ViewPath.DS.'MemberView.php');
	require_once(ViewPath.DS.'RegView.php');

	class LoginController  {
		// REMINDER: WHEN CREATING MODELS, THE MODEL MIGHT HAVE TO INHERIT FROM THE DATABASE OBJECTS IN THE HELPERS FOLDER?
		private $sessionModel;
		private $loginView;
		private $memberView;
		private $regView;
		private $user;
		private $userModel;
		private static $hashString = "sha256";
		private $cookie;
		private $username;
		private $passwordSafe;
		private $validation;
		private $AdminID;
		private $available;
		private $imagestypes;
		private static $UPLOADEDSUCCESSED = "Bilden har laddats upp!";
		private static $ErrorUPLOAD_ERR_TYPE = "Bilden måste vara av typen gif,jepg,jpg eller png!";
		private $imgRoot;
		private $uploadPage;
		private $fileName;
		private $delImage;
		private $imagesRepository;
		private $images;
		private $contact;
		private $emailContact;

		function __construct () {
			$this->sessionModel = new SessionModel();
			$this->loginView = new LoginView();
			$this->memberView = new MemberView();
			$this->regView = new RegView();
			$this->userModel = new UserModel();
			$this->user = new User($this->getuser(), $this->getSafePassword());
			$this->cookie = new CookieStorage();
			$this->validation = new validation();
			$this->available = new available();
			$this->imgRoot = getcwd()."/src/view/Images/";
			$this->uploadPage = new upload();
			$this->fileName = $this->getFileName();
			$this->imagesRepository = new ImagesRepository();
			$this->contact = new contact();
			$this->emailContact = new emailContact();

		}	

		public function getuser() {
			return $this->regView->GetUserName();
		}

		public function getPassword() {
			return $this->regView->GetPasswordOne();	
		}

		public function getSafePassword() {

			return $this->regView->getSafePassword();
		}

		public function getPasswordTwo() {

			return $this->regView->GetPasswordTwo();
		}

		public function getUsernameFromLoginView() {

			return $this->loginView->GetUsername();
		}
		public function getPasswordFromLoginView() {

			return $this->loginView->GetPassword();
		}

		public function hasSubmitToDelImg() {
			return $this->available->hasSubmitToDel();
		}

		// public function hasChecked() {
		// 	return $this->available->hasChecked();
		// }


		//funcations for contact from 
		public function getContctName() {
			return $this->contact->getName();
		}

		public function getContactEmail() {
			return $this->contact->getEmail();
		}

		public function getContactMsg() {
			return $this->contact->getMsg();
		}

		public function didPressSend() {
			return $this->contact->hasSubmitToSend();
		}

		public function sendContactFormInfo() {
			$Name = $this->getContctName();
			$Email = $this->getContactEmail();
			$Message = $this->getContactMsg();
			$this->validation->ContactFormValidation($Name,$Email,$Message);
		}


		public function getNameToEContact() {
			$this->emailContact->getName($this->getContctName());
		}

		public function getEmailToContact() {
			$this->emailContact->getEmail($this->getContactEmail());
		}

		public function getMsgToContact() {
			$this->emailContact->getMessage($this->getContactMsg());
		}

		public function doContact() {
			$Name = $this->getContctName();
			$Email = $this->getContactEmail();
			$Message = $this->getContactMsg();
			var_dump($this->didPressSend() == true);
			if ($this->didPressSend() == true) {
				# code...
				echo "string";
				if ($this->validation->ContactFormValidation($Name,$Email,$Message) === true) {
					# code...
					//TODO:: Code for contact form....
					$this->emailContact->EmailContact();
				}
				else {

					return $this->contact->ContactForm($this->validation->ContactFormValidation($Name,$Email,$Message));
				}
				

			}

		}

		public function RunLoginLogic () {
			global $remote_ip;
			global $b_ip;
			global $user_agent;
			$this->available->renderAllPics();


			// Set page reload flag
			$onReload = false;

			// Assign needed instances in local variables (Experiment).
			$loginView = clone $this->loginView;		
			$memberView = clone $this->memberView;
			$regView = clone $this->regView;
			$sessionModel = clone $this->sessionModel;
			$usermodel = clone $this->userModel;
			//TODO: MOVE IT!!!
			$this->contact->RenderContactForm();

			if($loginView->userPressRegNewUser() == true) {
				$regView->RenderRegForm();
				return true;
			}	

			if ($regView->DidUserPressReg() == true ) {
					$username = $this->getuser();
					$password = $this->getPassword();
					$passwordTwo = $this->getPasswordTwo();
				if($this->validation->ValidateRegistration($username,$password,$passwordTwo) === true) {
					$getUserName = $this->user->getUsername();
					$userEx = $this->userModel->userEX($getUserName);

					if ($userEx) {
						$usermodel->addNewUser($this->user);
					  	$loginView->RenderLoginForm($loginView->getNewUserSuccessMsg());
					}
					else {
						return $regView->RenderRegForm($this->validation->validateUserIfEX());
					}	
			}
			else {
				return $regView->RenderRegForm($this->validation->ValidateRegistration($username,$password,$passwordTwo));
				}
			
			}	

			// RENDER START PAGE, Render loginView if user is not already logged in and did not press Login Button
			if(!$sessionModel->IsLoggedIn() && !$loginView->UserPressLoginButton()
			 && !$memberView->RememberMe() && !$regView->DidUserPressReg() && !$sessionModel->IsAdminLoggedIn()) {
				// Generate output data
				$loginView->RenderLoginForm();
				return;
			}

			// USER LOGS OUT
			if ($memberView->UserPressLogoutButton()) {	
				$this->LogoutUser();
				return true;
			}

			// USER MAKES A LOGIN REQUEST
			if ($loginView->UserPressLoginButton()) {
				$result = $this->AuthenticateUser();
				//TODO:: MOVE IT!!!
				if ($result === true && $this->AdminID == 1)  {
					# code...
					 $this->uploadPage->RenderUploadForm();
				}
				// If comparison to database succeeded login user and render memberarea.
				if ($result === true) {

					$autoLoginIsSet = $loginView->AutoLoginIsChecked();
					$memberView->RenderMemberArea($autoLoginIsSet, $onReload);		
					return true;
				}
				else {

					// render loginform with errormessage.
					$loginView->RenderLoginForm($result);
				}

			}
			if ($sessionModel->IsAdminLoggedIn() && $sessionModel->IsLoggedIn() || ($memberView->RememberMe() && $memberView->RememberAdmin()))  {
					# test code...
					 $this->uploadPage->RenderUploadForm();
					
				}

				

			// USER IS ALREADY LOGGED IN AND RELOADS PAGE or USER LOGGED IN WITH REMEMBER ME AND RELOADS
			if ($sessionModel->IsLoggedIn() || $memberView->RememberMe() ||
				 $sessionModel->IsAdminLoggedIn() && $sessionModel->IsLoggedIn() || 
				 	($memberView->RememberMe() && $memberView->RememberAdmin())) {

					$onReload = true;
					$validId = hash(self::$hashString, $remote_ip . $user_agent);

					if ($sessionModel->IsStolen($validId)) {	
						$this->memberView->LogoutUser();
						$this->loginView->RenderLoginForm();

						return false;
					}

				// Check if somebody manipulated cookies.
				//$userN = $this->cookie->GetCookieUsername();

			
				// This if statement only checks the or block if user klicked remember me because of the && - operator.
				if ($memberView->RememberMe() && ($this->UserCredentialManipulated() || $this->CookieDateManipulated())) {
					
					$this->LogoutUser(false);
					return false;
				}
					$memberView->RenderMemberArea(false, $onReload);
					return true;
			}
		}

		// HELPER FUNCTIONS FOR THIS CONTROLLER
		// Authentication logic. 

		public function GetUserCookie(){
			$username = $this->loginView->GetUsername();
			return $this->userModel->getUserCookie($username);
			
		}
		protected function AuthenticateUser () {
			$username = $this->getUsernameFromLoginView();
			$password = $this->getPasswordFromLoginView();
			$message = $this->validation->Validate($username,$password);
			

			if ($message !== true) {
				
				return $message;
			}
			
			$username = $this->loginView->GetUsername();
			$userAuthenticated = $this->userModel->AuthenticateUser($username);
			$username = $userAuthenticated[1];
			$password = $userAuthenticated[2];
			$this->AdminID = $userAuthenticated[4];			
			$this->memberView->getSafeId($this->AdminID);
			$pass = $this->loginView->GetPassword();
			$final = crypt($pass, $password);
			$cryptId = $this->AdminID;
			$userCookie =  $this->GetUserCookie();
			$usr = $userCookie[1];
			$pws = $userCookie[2];

			if ($final === $password && $userAuthenticated) {

				// TODO: Check that this is not done more than once.
				$this->sessionModel->LoginUser($this->user);
				if ($this->loginView->AutoLoginIsChecked()) {
					// TODO: Change 30 to a constant/variable.
					$cookieTimestamp = time() + 60*60*24*30;
					$this->memberView->SaveUserCredentials($username, $pws, $cookieTimestamp,$cryptId);
					$this->userModel->SaveCookieTimestamp($cookieTimestamp,$this->sessionModel->GetUsername());
				}

				return true;
			}
			else {

				return $this->validation->GetLoginErrorMessage($username);
			}
		}

		protected function UserCredentialManipulated () {

			// COMPARE TO HASHED PASSWORD!
			// TODO: MOVE THIS TO THE VIEW.
			// TODO: Get the cookie values from the view before sending them to AuthenticateUser.
			// execute return below if passwords in database are hased.
			// return !@$this->userModel->AuthenticateUser($_COOKIE['username'], $_COOKIE['password']);
			// execute below if passwords in database are not hashed.
			try {

				$username = $this->memberView->GetCookieUsername();
				$password = $this->memberView->GetCookiePassword();				
			}
			catch (\Exception $e) {
				// Handle error: Something went wrong, could not find cookies, return true so that user is thrown out.
				return true;
			}

			return !@$this->userModel->UserCredentialManipulated($username, $password);
		}

		protected function CookieDateManipulated () {
			// TODO: Move this logic to view.
			$username = $this->memberView->GetCookieUsername();
			$currentTime = time();
			$cookieExpTime = ($this->userModel->GetCookieDateById($username));

			if ($currentTime > $cookieExpTime) {

				return true;

			}
			return false;
		}

		protected function LogoutUser ($isDefaultLogout = true) {
			$this->memberView->LogoutUser();
			$this->loginView->RenderLogoutView($isDefaultLogout);
		}

		public function DidHasSubmit() {
			return $this->uploadPage->hasSubmitToUpload();
		}

		public function getFileName() {
			 return $this->uploadPage->GetImgName();
		}

		public function getImgPath() {
			$this->validation->getImgRoot($this->imgRoot);
		}

		public function imgUpload() {
	
			//TODO:: READ MORE ABOUT phpinfo() , getcwd() , extension=php_mbstring.dll
			// extension=php_exif.dll & exif_imagetype() IN PHP.NET....
			//var_dump(phpinfo());

			$counter = 1;
		//	$this->fileName = $this->getFileName();
			$this->validation->getFileName($this->fileName);
			$Images = glob("src/view/Images/*.*");
			if ($this->hasSubmitToDelImg() == true) {
				# code... 
				foreach ($Images as $value) {
					# code...

						unlink($value);
						//echo "bilden togs bort!!!!!!";
				}
			}
			else{}	

			

			if ($this->DidHasSubmit() == true) {
				# code...
				if (is_uploaded_file($_FILES[$this->fileName]['tmp_name'])) {
					# code...
					if (exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_GIF ||
						 exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_JPEG ||
						 	 exif_imagetype($_FILES[$this->fileName]['tmp_name']) == IMAGETYPE_PNG) {
						# code...
						if (file_exists($this->imgRoot.$_FILES[$this->fileName]['name'])) {
							# code...
							$FileNameInfo = new SplFileInfo($_FILES[$this->fileName]['name']);
							$extension = $FileNameInfo->getExtension();
							$pointEx = substr(strrchr($_FILES[$this->fileName]['name'],"."), -4);
							$FileNameWithOutEx = $FileNameInfo->getBasename($pointEx);

							while (file_exists($this->imgRoot.$_FILES[$this->fileName]['name'])) {
								# code...
								$_FILES[$this->fileName]['name'] = $FileNameWithOutEx."(".$counter++.")." . $extension;
							}
						}
						if ($_FILES[$this->fileName]['size'] < 2000000) {
							# code...
							 	if (move_uploaded_file($_FILES[$this->fileName]['tmp_name'], $this->imgRoot.$_FILES[$this->fileName]['name']) == true) {
							 		# code...
							 			$this->images = new Images($_FILES[$this->fileName]['name']);
							 			
							 			$this->imagesRepository->AddPics($this->images);

							 			$this->available->renderAllPics();

							 			return $this->available->DisplayAllImages(self::$UPLOADEDSUCCESSED);
							 	}
								
						}
					}
					else {
							return $this->uploadPage->imageUpload(self::$ErrorUPLOAD_ERR_TYPE);
						}
				}
				else {
						return $this->uploadPage->imageUpload($this->validation->errorToMessage());
					}
			}
		}
	}