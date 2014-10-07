<?php

class available{
// test code.............
	private $mainView;
	public function __construct() {
		$this->mainView = new HTMLView();
	}

	public function writeHtml(){
		return $h = "testddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd";
	}

		public function Rendertest() {

			$h = $this->writeHtml();
			echo $this->mainView->echoHTML($h);
		}

}