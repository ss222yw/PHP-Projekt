<?php
	
	class NavigationView {

		private $mainView;
		private $AdminID;
		private $sessionModel;
		private $memberView;
		private $controller;


		private static $page = "page";

		public static $contact = "contact";
		public static $upload ="upload";
		public static $interest = "interest";
		public static $service = "service";
		public static $HomePage = "HomePage";
		public static $Avaliable = "Avaliable";

		public function __construct() {
			$this->mainView = new HTMLView();
			$this->sessionModel = new SessionModel();
			$this->memberView = new MemberView();
			$this->controller = new LoginController();

		}



		public function showMenu() {

			    $html = "<div id='menu'>";
			    $html .= "<a href='?".self::$page."=".self::$HomePage."'>Hem</a>&nbsp;&nbsp;";
				$html .= "<a href='?".self::$page."=".self::$Avaliable."'>Ledigt</a>&nbsp&nbsp;";
				$html .= "<a href='?".self::$page."=".self::$contact."'>Kontakta oss</a>&nbsp;&nbsp;";
				$html .= "<a href='?".self::$page."=".self::$interest."'>Intresseanmälan</a>&nbsp;&nbsp;";
				$html .= "<a href='?".self::$page."=".self::$service."'>Felanmälan</a><br>";
			    $html .= "<a href='?".self::$page."=".self::$HomePage."'><img src='hhfastigheter.gif' id='hh'></a><br>";	
				$html .= "</div>";
				return $html;

		}

		public function renderShowMenu() {

			$html = $this->showMenu();
			echo $this->mainView->echoHTML($html);
		}


		public function RedirectToHomePage() {
			header('Location:' .$_SERVER['PHP_SELF']);
		}

		public function RedirectToErrorPage() {
			header('Location: ErrorPage.html');
		}
 
		public function getPage() {
			if (isset($_GET[self::$page])) {
				return $_GET[self::$page];
			}
			return self::$HomePage;
		}

	}