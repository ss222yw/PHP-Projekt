<?php

class available{
// test code.............

	private $mainView;
	private $del = "delete";
	private $checked = "checked";

	public function __construct() {
		$this->mainView = new HTMLView();
	}

	public function DisplayAllImages($msg = '') {

		$responseMessages = '';

			if ($msg != '') {
				$responseMessages .= '<p>' . $msg . '</p>';
			}

		$Images = glob("src/view/Images/*.*");
		$NrOfImgs = Count($Images);
		$pics = "";
		for ($i=0; $i < $NrOfImgs; $i++) { 
			# code...
			$pics .= '<img src="'.$Images[$i].'" id="ImgSize">';

		}
			$msgs = $responseMessages;	
			echo $responseMessages;
		return $pics;	
	}


	public function renderAllPics() {
		echo $this->mainView->echoHTML($this->DisplayAllImages());
	}

	public function deleteImg() {
		$remove = '<form id="delete" enctype="multipart/form-data" method="post" action="?delete">'.
	//	'<input type="checkbox" name="'.$this->checked.'">'.
		'<input type="submit" name="'.$this->del.'" value="Ta bort">'.
		'</form>';
		return $remove;
	}


	public function hasSubmitToDel() {
		if (isset($_POST[$this->del])) {
			# code...
			return true;
		}
	}

	public function hasChecked() {
		if (isset($_POST[$this->checked])) {
			# code...
			return true;
		}
	}

}										