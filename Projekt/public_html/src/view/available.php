<?php

class available{
// test code.............

	private $mainView;

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

}