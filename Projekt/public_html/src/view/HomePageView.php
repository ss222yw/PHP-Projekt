<?php
	
	//the require once here just to show the coupling between classes.	
	require_once(HelperPath.DS.'HTMLView.php');
	
	class HomePageView {

		private $mainView;

		public function __construct() {

			$this->mainView = new HTMLView();
		}


		

		public function homePageForm() {
			$Images = glob("src/view/Images/*.*");
			$htmlHomePage = '<div id="middelText">';
			$htmlHomePage .= '<h3>Välkommen till HH fastigheter , här är våran ledigt för mer info tryck <a href="?page=Avaliable">här</a></h3>';
			$htmlHomePage .= '</div>';
			$htmlHomePage .= '<div id="middel">';
			$htmlHomePage .= '<div class="fadein">';
			foreach ($Images as $value) {
				if(basename($value) != "") {
					 $htmlHomePage .= '<img src="'.$value.'" id="ImgSize" class="img-responsive" >';
				}
				else {
						$htmlHomePage .= '<img src="Bild-Saknas.jpg" id="ImgSize" class="img-responsive" >';
				}
			}
			$htmlHomePage .= '</div></div>';
			return $htmlHomePage;
		}

		public function renderHomePage() {
			$htmlHomePage  = $this->homePageForm();
			echo $this->mainView->echoHTML($htmlHomePage);
		}
	}