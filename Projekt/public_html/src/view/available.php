<?php

class available{
	
	private $mainView;
	private $del = "delete";
	private $session = "session";
	private $hiddenImgID = "hiddenImgID";
	private $hiddenImg = "hiddenImg";
	private $yesDel = "yesDel";
	private $NoDel = "NoDel";
	private static $page = "page";
	public static $upload ="upload";

	public function __construct() {
		$this->mainView = new HTMLView();
	}

	//Render all Images for Admin.
	public function DisplayAllImages($msg = '') {

		$responseMessages = '';
		if ($msg != '') {
			$responseMessages .= '<p>' . $msg . '</p>';
		}

		$Images = glob("src/view/Images/*.*");
		$pics = "<a href='?".self::$page."=".self::$upload."'>Ladda upp bilder</a>&nbsp;";
		$pics .= "<br><br>";
		
		foreach ($Images as $value) {		
			$pics .= '<img src="'.$value.'" id="ImgSize">';
			$pics .= '<form id="delete" enctype="multipart/form-data" method="post" action="">'.
			'<input type="hidden" name="'.$this->hiddenImgID.'" value="'.basename($value).'">'.
			'<input type="submit" name="'.$this->del.'" value="Ta bort">'.
			'</form>';
			
			}
			$msgs = $responseMessages;	
			echo $responseMessages;
			return $pics;	

		}
			

	//Render all images for users.
	public function DisplayAllImagesForUsers() {
		$Images = glob("src/view/Images/*.*");
		$pic = "<br><h2>Lediga lägenheter och lokaler.</h2><br><br><br>";
		foreach ($Images as $value) {
			$pic .= '<img src="'.$value.'" id="ImgSize">';
		}
		return $pic;	
	}

	public function renderAllPicsForUsers() {
		echo $this->mainView->echoHTML($this->DisplayAllImagesForUsers()) ."<br>";
	}

	public function renderAllPics() {
		echo $this->mainView->echoHTML($this->DisplayAllImages()) ."<br>";
	}

	
	// confirm that admin want to remove an image or cancel.
	public function areYouSure() {
			$remove = '<form id="delete" enctype="multipart/form-data" method="post" action="">'.
			'vill du verkligen ta bort '.$_SESSION[$this->session].'?'.
			'<input type="hidden" name="'.$this->hiddenImg.'" value="'.$_SESSION[$this->session].'">'.
			'<input type="submit" name="'.$this->yesDel.'" value="Ja!Ta bort">'.
			'<input type="submit" name="'.$this->NoDel.'" value ="Avbryt">'.
			'</form>';
		
		return $remove;
	}

	public function renderAreYouSure() {
		echo $this->mainView->echoHTML($this->areYouSure()) ."<br>";
	}


	public function getYesDel() {
		if (isset($_POST[$this->yesDel])) {
			return true;
		}
	}

	public function getNoDel() {
		if (isset($_POST[$this->NoDel])) {
			return true;
		}
	}


	public function getHiddenId() {
		if (isset($_POST[$this->hiddenImgID])) {
			$_SESSION[$this->session] = $_POST[$this->hiddenImgID];
			return $_POST[$this->hiddenImgID];
		}
		
	}

	public function getSessionHidden() {
		if (isset($_POST[$this->hiddenImg])) {
			return $_POST[$this->hiddenImg];
		}
	}

	public function hasSubmitToDel() {
		if (isset($_POST[$this->del])) {
			return true;
		}
	}

}										