<?php

	class HomePageView {

		private $mainView;

		public function __construct() {

			$this->mainView = new HTMLView();
		}

		public function homePageForm() {
			return $htmlHomePage = "test så kan se om allt kopplat rätt ..............<br>";
		}

		public function renderHomePage() {
			$htmlHomePage  = $this->homePageForm();
			echo $this->mainView->echoHTML($htmlHomePage);
		}
	}