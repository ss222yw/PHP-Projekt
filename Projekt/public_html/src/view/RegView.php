<?php

require_once(HelperPath.DS.'HTMLView.php');

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
					
				$responseMessages .= '<p>' . $message . '</p>';
			}


			$RegHTML =

					'<h2>Registrerar användare</h2> '.

					'<form  enctype="multipart/form-data" method="post" action="?Registrera">' .
					'<fieldset>' .
					'<legend>Registrera ny användare</legend>' .
					$responseMessages .
					'<label for="'.$this->username.'">Namn :  </label>' .
					'<input type="text" name="'.$this->username.'" placeholder="Namn minst 3 tecken" value="'.strip_tags($this->GetUserName()).'" maxlength="30" id="username" /> ' .
					'<br>'.
					'<label for="'.$this->passwordOne.'">Lösenord : </label>' .
					'<input type="password" name="'.$this->passwordOne.'" placeholder="Lösenord minst 6 tecken" maxlength="30" id="password" /> ' .
					'<br>'.
					'<label for="'.$this->passwordTwo.'">Reptera Lösenord : </label>' .
					'<input type="password" name="'.$this->passwordTwo.'" placeholder="Reptera lösenord" maxlength="30" id="passwordTwo" /> ' .
					'<br>'.
					'<br>'.
					'<label for="Registrera">Skicka : </label>' .
					'<input type="submit" name="Registrera" id="submit" value="Registrera" />'.
					'<br>'.
					'<br>'.
					'<a href="?login">Tillbaka</a>'.
				    '</fieldset>
					</form>';
			return $RegHTML;

	}

	public function RenderRegForm($errorMessage = '') {

			$RegHTML = $this->GetRegFormHTML($errorMessage);
			echo $this->mainView->echoHTML($RegHTML);
		}


	public function GetUserName() {
		if (isset($_POST[$this->username])) {
			return htmlentities($_POST[$this->username]);
		}
	}


	public function GetPasswordOne() {
		if (isset($_POST[$this->passwordOne])) {
			return htmlentities($_POST[$this->passwordOne]);
		}	
	}

	public function GetPasswordTwo() {
		if (isset($_POST[$this->passwordTwo])) {
			return htmlentities($_POST[$this->passwordTwo]);
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