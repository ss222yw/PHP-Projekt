<?php

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
				$responseMessages .= '<p>' . $msg . '</p>';
			}

			$uploadForm = 	'<h3>Ladda upp en bild på bostad/lokal med information.</h3><br>'.
			'<div id=upload>'.
			'<form id="upload" enctype="multipart/form-data" method="post" action="">' .
			'<fieldset class="upload">' .
			'<input type="File" name="'.$this->images.'">'.
			'<br>'.
			'<br>'.
			'Beskriv bilden'.
			'<br>'.
			'<textarea name="'.$this->msg.'" cols="45" rows="5" maxlength="500" placeholder="Beskriv bilden här...">'.$this->getComments().'</textarea>' .
			'<br>'.
			'<br>'.
			'<input type="submit" name="'.$this->upload.'" value="Ladda upp">'.
			'</fieldset>'.
			'</form>'.
			'</div>';
			echo $responseMessages;
			return $uploadForm;
	}

	public function renderAllImages($imgRoot) {
		$this->show = $imgRoot;
	}

	public function getComments() {
		if (isset($_POST[$this->msg])) {
			# code...
			return $_POST[$this->msg];
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