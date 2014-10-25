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



		//Show menu
		public function showMenu() {	
				$html = '<nav class="navbar navbar-default" role="navigation">';
				$html .='<div class="navbar-header">
     					   <button type="button" class="navbar-toggle collapsed"
     					 	 data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      				     	 <span class="sr-only">Toggle navigation</span>
				             <span class="icon-bar"></span>
				             <span class="icon-bar"></span>
				             <span class="icon-bar"></span>
				           </button>
				         </div>';
				$html .= '<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">';
			    $html .= "<ul class='nav navbar-nav'>";
			    $html .= "<li><a href='?".self::$page."=".self::$HomePage."'>Hem</a></li>";
				$html .= "<li><a href='?".self::$page."=".self::$Avaliable."'>Ledigt</a></li>";
				$html .= "<li><a href='?".self::$page."=".self::$contact."'>Kontakta oss</a></li>";
				$html .= "<li><a href='?".self::$page."=".self::$interest."'>Intresseanmälan</a></li>";
				$html .= "<li><a href='?".self::$page."=".self::$service."'>Felanmälan</a></li>";
				$html .= "</ul>";
				$html .= "</div>";
				$html .="</nav>";
			    $html .= "<a href='?".self::$page."=".self::$HomePage."'><img src='apple-touch-icon-144x144.png' class='img-thumbnail' id='hh'></a><br>";	
				return $html;

		}

		// render show menu
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