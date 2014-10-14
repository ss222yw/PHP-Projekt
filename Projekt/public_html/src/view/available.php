<?php

class available{
	
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
		$pics = "<br><h2>Lediga lägenheter och lokaler.</h2><br><br><br>";
		for ($i=0; $i < $NrOfImgs; $i++) { 
		
			$pics .= '<img src="'.$Images[$i].'" id="ImgSize">';

		}
			$msgs = $responseMessages;	
			echo $responseMessages;
		return $pics;	
	}

	public function renderAllPics() {
		echo $this->mainView->echoHTML($this->DisplayAllImages()) ."<br>";
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
			return true;
		}
	}

	public function hasChecked() {
		if (isset($_POST[$this->checked])) {
			return true;
		}
	}

}										