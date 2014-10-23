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
					
				$responseMessages .= '<strong>' . $message . '</strong>';
			}


			$RegHTML =

					'<h2>Registrera ny användare</h2> '.
					'<form  class="form-horizontal" enctype="multipart/form-data" method="post" action="?Registrera">' .
					$responseMessages .
					'<div class="form-group">'.
					'<div class="col-xs-4">'.
					'<label for="'.$this->username.'">Namn :  </label>' .
					'<input type="text" name="'.$this->username.'" class="form-control" placeholder="Namn minst 3 tecken" value="'.strip_tags($this->GetUserName()).'" maxlength="30" id="username" /> ' .
					'</div>'.
					'</div>'.
					'<div class="form-group">'.
					'<div class="col-xs-4" >'.
					'<label for="'.$this->passwordOne.'">Lösenord : </label>' .
					'<input type="password" name="'.$this->passwordOne.'" class="form-control" placeholder="Lösenord minst 6 tecken" maxlength="30" id="password" /> ' .
					'</div>'.
					'</div>'.
					'<div class="form-group">'.
					'<div class="col-xs-4">'.
					'<label for="'.$this->passwordTwo.'">Reptera Lösenord : </label>' .
					'<input type="password" name="'.$this->passwordTwo.'" class="form-control" placeholder="Reptera lösenord" maxlength="30" id="passwordTwo" /> ' .
					'</div>'.
					'</div>'.
					'<input type="submit" name="Registrera" id="submit" value="Registrera" class="btn btn-default"/>'.
					'<br>'.
					'<br>'.
					'<a href="?login">Tillbaka</a>'.
					'</form>';
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