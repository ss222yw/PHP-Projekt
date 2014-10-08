<?php

class available{
// test code.............
	private $mainView;
	private $upload = "upload";
	private $images = "images";
	private $validation;

	public function __construct() {
		$this->mainView = new HTMLView();
		$this->validation = new validation();
	}

	public function imageUpload($msg = '') {

			$responseMessages = '';

			if ($msg != '') {
				//	var_dump($msg);
				$responseMessages .= '<p>' . $msg . '</p>';
			}

		$uploadForm = 	'<br>'.
			'<form id="available" enctype="multipart/form-data" method="post" action="?available">' .
				'<fieldset class="upload">' .
				'<input type="file" name="'.$this->images.'">'.
				'<input type="submit" name="'.$this->upload.'" value="Ladda upp">'.
				'</fieldset>'.
			'</form>';
			echo $responseMessages;
			return $uploadForm;
	}

	public function Rendertest($errorMessage = '') {

		$uploadForm = $this->imageUpload($errorMessage);
		echo $this->mainView->echoHTML($uploadForm);
	}

	public function GetImgName() {

			return $this->images;
		
	}


	public function hasSubmitToUpload() {
		if (isset($_POST[$this->upload])) {
			# code...
			return $_POST[$this->upload] ;
		}
	}


}