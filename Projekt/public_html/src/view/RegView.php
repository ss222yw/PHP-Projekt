<?php
//the require once here just to show the coupling between classes.	
require_once(HelperPath.DS.'HTMLView.php');
require_once(HelperPath.DS.'safe.php');

class RegView{

	private $mainView;
	private $username = "username";
	private $passwordOne = "password";
	private $passwordTwo = "passwordTwo";
	private $safe;


	public function __construct() {

		$this->mainView = new HTMLView();
		$this->safe = new safe();
		
	}

	public function getSafePassword() {
			return $this->safe->create_hash($this->GetPasswordOne());
		
	}

	public function GetRegFormHTML($message = '') {

		    $responseMessages = ''; 

			if ($message != '') {
					
				$responseMessages .= '<strong>' . $message . '</strong>';
			}


			$RegHTML =

					'<h2>Registrera ny användare</h2> '.
					'<form  class="form-horizontal" enctype="multipart/form-data" method="post" action="?page=Registrera">' .
						$responseMessages .
						'<label for="'.$this->username.'">Namn :  </label>' .
						'<input type="text" name="'.$this->username.'"  placeholder="Namn minst 3 tecken" class="form-control" value="' .strip_tags($this->GetUserName()). '" maxlength="30"  /> ' .
						'<label for="'.$this->passwordOne.'">Lösenord : </label>' .
						'<input type="password" name="'.$this->passwordOne.'" class="form-control" placeholder="Lösenord minst 6 tecken" maxlength="30" id="password" /> ' .
						'<label for="'.$this->passwordTwo.'">Reptera Lösenord : </label>' .
						'<input type="password" name="'.$this->passwordTwo.'" class="form-control" placeholder="Reptera lösenord" maxlength="30" id="passwordTwo" /> ' .
						'<input type="submit" name="Registrera" id="submit" value="Registrera" class="btn btn-default"/>'.
						'<br>'.
						'<br>'.
						'<a href="?page=HomePage">Tillbaka</a>'.
					'</form>';
			return $RegHTML;

	}

	public function RenderRegForm($errorMessage = '') {

			$RegHTML = $this->GetRegFormHTML($errorMessage);
			echo $this->mainView->echoHTML($RegHTML);
		}


	public function GetUserName() {
		if (isset($_POST[$this->username])) {
			return $_POST[$this->username];	
		}
	}


	public function GetPasswordOne() {
		if (isset($_POST[$this->passwordOne])) {
			return $_POST[$this->passwordOne];
		}	
	}

	public function GetPasswordTwo() {
		if (isset($_POST[$this->passwordTwo])) {
			return $_POST[$this->passwordTwo];
		}
	}


	public function UserPressReturn() {
		if (isset($_GET['login'])) {
			return true;
		}
		
	}

	public function DidUserPressReg() {
		if (isset($_POST['Registrera'])) {
			return true;
		}
		
	}

	
}