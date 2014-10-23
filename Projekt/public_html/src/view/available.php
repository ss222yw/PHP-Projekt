<?php

class available{
	
	private $mainView;
	private $del = "delete";
	private $session = "session";
	private $hiddenImgID = "hiddenImgID";
	private $hiddenImg = "hiddenImg";
	private $hiddenImgEdit = "hiddenImgEdit";
	private $yesDel = "yesDel";
	private $NoDel = "NoDel";
	private static $page = "page";
	public static $upload ="upload";
	private $uploadPage;
	private $msg = "message";
	private $EditInfo = "Edit";
	private $SaveEdit ="saveEDIT";
	private $imagesModel;
	private $cookieStorage;

	public function __construct() {
		$this->mainView = new HTMLView();
		$this->uploadPage = new upload();
		$this->imagesModel = new ImagesModel();
		$this->cookieStorage = new CookieStorage();
	}



	//Render all Images for Admin.
	public function DisplayAllImages($msg = '') {

		$responseMessages = '';
		if ($msg != '') {
			$responseMessages .= '<strong>' . $msg . '</strong>';
		}

		$MsgSuccesUpload = $this->cookieStorage->GetMessageCookie();
		echo '<strong>' .$MsgSuccesUpload . '</strong>';
	    $this->cookieStorage->DeleteMessageCookie();	
 
		$Images = glob("src/view/Images/*.*");
		$pics = "<a href='?".self::$page."=".self::$upload."'>Ladda upp bilder</a>&nbsp;";
		$pics .= "<br><br>";
		
		foreach ($Images as $value) {	
 			$img = $this->imagesModel->getImages(basename($value));	
				$SoSoon = "";
			if($img->GetMSG() == "") {
				$SoSoon .="Finns ingen beskrivning i nu läge...<br> TRYCK redigera! för att kunna lägga till beskrivningen ";
			}

			$pics .= '<img src="'.$value.'" id="ImgSize" class="img-responsive">';
			$pics .= '<form id="delete" enctype="multipart/form-data" method="post" action="">'.
			'<br>'.
			'<strong>Bildbeskrivning</strong>'.
			'<br>'.
			'<br>'.
			$img->GetMSG().
			$SoSoon.
			'<br>'.
			'<br>'.
			'<input type="hidden" name="'.$this->hiddenImgID.'" value="'.basename($value).'">'.
			'<input type="submit" name="'.$this->del.'" value="Ta bort" class="btn btn-danger">&nbsp;'.
			'<input type="submit" name="'.$this->EditInfo.'" value="Redigera" class="btn btn-warning">'.
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
			$img = $this->imagesModel->getImages(basename($value));
			$SoSoon = "";
			if($img->GetMSG() == "") {
				$SoSoon .="Finns ingen beskrivning i nu läge...";
			}
			$pic .= '<img src="'.$value.'" id="ImgSize" class="img-responsive">'.
			'<br>'.
			'<br>'.
			'<strong>Bildbeskrivning</strong>'.
			'<br>'.
			'<br>'.
			$img->GetMSG().
			$SoSoon.
			'<br>'.
			'<br>';

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
			'<fieldset class="delete">'.
			'<div class="alert alert-danger role="alert"><strong>Vill du verkligen ta bort '.$_SESSION[$this->session].' med beskrivningen ?</strong></div>'.
			'<br>'.
			'<br>'.
			'<input type="hidden" name="'.$this->hiddenImg.'" value="'.$_SESSION[$this->session].'">'.
			'<input type="submit" name="'.$this->yesDel.'" value="Ja!Ta bort" class="btn btn-danger">&nbsp;&nbsp;'.
			'<input type="submit" name="'.$this->NoDel.'" value ="Avbryt" class="btn btn-success">'.
			'</fieldset>'.
			'</form>';
		
		return $remove;
	}


	public function EditUploadedInformation() {

			$img = $this->imagesModel->getImages($this->getHiddenId());
			$saveEdit = "<strong>Redigera ".$img->getImgName()."</strong><br><br>";
 			$saveEdit .= '<form id="SaveEdit" enctype="multipart/form-data" method="post" action="">'.
 			'<fieldset class="Edit">'.
			'&nbsp;'.
			'<textarea name="'.$this->msg.'" cols="45" rows="5" maxlength="500" placeholder="Beskriv bilden här..." wrap="hard">'.strip_tags($img->GetMSG()).'</textarea>' .
			'<br>'.
			'<br>'.
			'<input type="hidden" name="'.$this->hiddenImgEdit.'" value="'.$img->getImgName().'">'.
			'<input type="submit" name="'.$this->SaveEdit.'" value="Spara" class="btn btn-success">&nbsp;&nbsp;'.
			'<input type="submit" name="'.$this->NoDel.'" value ="Avbryt" class="btn btn-default">'.
			'</fieldset>'.
			'</form>';
		
			return $saveEdit;
	}

	public function renderEditUploadedInformation() {
		echo $this->mainView->echoHTML($this->EditUploadedInformation()) ."<br>";
	}

	public function renderAreYouSure() {
		echo $this->mainView->echoHTML($this->areYouSure()) ."<br>";
	}

	public function hasSubmitToEdit() {
		//var_dump(isset($_POST[$this->EditInfo]));
		if (isset($_POST[$this->EditInfo])) {
			# code...
			return true;
		}
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

	public function getSessionHiddenEdit() {
		if (isset($_POST[$this->hiddenImgEdit])) {
			# code...
			return $_POST[$this->hiddenImgEdit];
		}
	}

	public function hasSubmitToDel() {
		if (isset($_POST[$this->del])) {
			return true;
		}
	}


	public function GetImageComment() {
		if (isset($_POST[$this->msg])) {
			# code...
			return nl2br($_POST[$this->msg]);
		}
	}

	public function GetSaved() {
		if (isset($_POST[$this->SaveEdit])) {
			# code...
			return true;
		}
	}

}										