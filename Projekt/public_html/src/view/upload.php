<?php

class upload {
	private $mainView;
	private $upload = "upload";
	private $images = "images";
	private $show;

	public function __construct() {
		$this->mainView = new HTMLView();
	}

	public function imageUpload($msg = '') {

			$responseMessages = '';

			if ($msg != '') {
				$responseMessages .= '<p>' . $msg . '</p>';
			}

		$uploadForm = 	'<br>'.
			'<div id=upload>'.
			'<form id="upload" enctype="multipart/form-data" method="post" action="">' .
				'<fieldset class="upload">' .
				'<input type="File" name="'.$this->images.'">'.
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


	public function RenderUploadForm($errorMessage = '') {

		$uploadForm = $this->imageUpload($errorMessage);
		echo $this->mainView->echoHTML($uploadForm);
	}

	public function GetImgName() {
		if (isset($_FILES[$this->images])) {
			# code...
			return $this->images;
		}
		
	}


	public function hasSubmitToUpload() {
		if (isset($_POST[$this->upload])) {
			# code...
			return true;
		}
	}

}