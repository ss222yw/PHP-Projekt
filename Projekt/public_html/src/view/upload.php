<?php

//the require once here just to show the coupling between classes.	
require_once(HelperPath.DS.'HTMLView.php');

class upload {
	private $mainView;
	private $upload = "upload";
	private $images = "images";
	private $show;
	private $msg = "message";

	public function __construct() {
		$this->mainView = new HTMLView();
	}



	//render upload form.
	public function imageUpload($msg = '') {
			
			$responseMessages = '';
			if ($msg != '') {
				$responseMessages .= '<strong>' . $msg . '</strong>';
			}
			
			echo  $responseMessages;
			$uploadForm = 	'<h4>Ladda upp en bild på bostad/lokal med/utan beskrivning.</h4>'.
			'<div id=upload>'.
			'<form class="form-horizontal" enctype="multipart/form-data" method="post" action="">' .
			'<fieldset class="upload">' .
			'<br>'.
			'<input type="File" name="'.$this->images.'"" >'.
			'<br>'.
			'<br>'.
			'Beskriv bilden'.
			'<br>'.
			'<textarea name="'.$this->msg.'" cols="35" rows="5"  maxlength="500" placeholder="Beskriv bilden här... " wrap="hard">'.$this->getComments().'</textarea>' .
			'<br>'.
			'<br>'.
			'<input type="submit" name="'.$this->upload.'" value="Ladda upp" class="btn btn-info" >'.
			'</fieldset>'.
			'</form>'.
			'</div>';
			return $uploadForm;
	}

	public function renderAllImages($imgRoot) {
		$this->show = $imgRoot;
	}

	public function getComments() {
		if (isset($_POST[$this->msg])) {
			return nl2br($_POST[$this->msg]);
		}
	}



	public function RenderUploadForm($errorMessage = '') {

		$uploadForm = $this->imageUpload($errorMessage);
		echo $this->mainView->echoHTML($uploadForm);
	}

	public function GetImgName() {
		if (isset($_FILES[$this->images])) {
			return $this->images;
		}
		
	}

	public function hasSubmitToUpload() {
		if (isset($_POST[$this->upload])) {
			return true;
		}
	}

}