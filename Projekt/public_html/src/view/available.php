<?php

class available{
	
	private $mainView;
	private $del = "delete";
	private $checked = "checked";
	private $imgId;
	private $imagesRepository;
	private $imgName;
	private $ID;
	private $imgname;
	private $imageid;
	private $imagesModel;
	private $session = "session";

	public function __construct() {

		$this->mainView = new HTMLView();
		// $this->imagesRepository = new ImagesRepository();
		// $this->imagesModel = new ImagesModel();
		// $this->images = new Images($img="",$id="");
	}

	public function DisplayAllImages($msg = '') {

		$responseMessages = '';

			if ($msg != '') {
				$responseMessages .= '<p>' . $msg . '</p>';
			}

		$Images = glob("src/view/Images/*.*");
		//$NrOfImgs = Count($Images);
		$pics = "<br>";
		//for ($i=0; $i < $NrOfImgs; $i++) { 
		foreach ($Images as $value) {
			# code...
		
			$pics .= '<img src="'.$value.'" id="ImgSize">';

			$pics .= '<form id="delete" enctype="multipart/form-data" method="post" action="">'.
			'<input type="hidden" name="hiddenImgID" value="'.basename($value).'">'.
			'<input type="submit" name="'.$this->del.'" value="Ta bort">'.
			'</form>';

		}
			$msgs = $responseMessages;	
			echo $responseMessages;
		return $pics;	
	}

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

	

	public function areYouSure() {
			
			$remove = '<form id="delete" enctype="multipart/form-data" method="post" action="">'.
			'vill du verkligen ta bort '.$_SESSION[$this->session].'?'.
			'<input type="hidden" name="hiddenImg" value="'.$_SESSION[$this->session].'">'.
			'<input type="submit" name="yesDel" value="Ja!Ta bort">'.
			'<input type="submit" name="NoDel" value ="Avbryt">'.
			'</form>';
		
		return $remove;
	}

	public function renderAreYouSure() {
		echo $this->mainView->echoHTML($this->areYouSure()) ."<br>";
	}


	public function getYesDel() {
		if (isset($_POST['yesDel'])) {
			# code...
			return true;
		}
	}

	public function getNoDel() {
		if (isset($_POST['NoDel'])) {
			# code...
			return true;
		}
	}




	public function getHiddenId() {
		if (isset($_POST['hiddenImgID'])) {
			# code...
			$_SESSION[$this->session] = $_POST['hiddenImgID'];

			return $_POST['hiddenImgID'];
		}
		
	}

	public function getSessionHidden() {
		if (isset($_POST['hiddenImg'])) {
			# code...
			return $_POST['hiddenImg'];
		}
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