<?php

	class HomePageView {

		private $mainView;

		public function __construct() {

			$this->mainView = new HTMLView();
		}


		

		public function homePageForm() {
			$Images = glob("src/view/Images/*.*");
			$htmlHomePage = "<h2>Välkommen till HH fastigheter , här är våran ledigt.</h2>";
			$htmlHomePage .= '<div class="fadein">';
			foreach ($Images as $value) {
				 $htmlHomePage .= '<img src="'.$value.'" id="ImgSize" class="img-responsive" >';
			}
			$htmlHomePage .= '</div>';
			return $htmlHomePage;
		}

		public function renderHomePage() {
			$htmlHomePage  = $this->homePageForm();
			echo $this->mainView->echoHTML($htmlHomePage);
		}
	}