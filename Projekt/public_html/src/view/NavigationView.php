<?php
	
	class NavigationView {

		private $mainView;
		private $AdminID;
		private $sessionModel;
		private $memberView;
		private $controller;


		private static $page = "page";

	//	public static $login = "login";
	//	public static $logout = "logout";
	//	public static $registrera = "Registrera";
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
		//	$html .= "<a href='?".self::$page."=".self::$login."'>Logga in</a>&nbsp;";
		//	$html .= "<a href='?".self::$page."=".self::$logout."'>Logga out</a>&nbsp;";
			if ($this->controller->AuthenticateUser() &&$this->AdminID == 1 ||
				 $this->sessionModel->IsAdminLoggedIn() && $this->sessionModel->IsLoggedIn() || 
				 		($this->memberView->RememberMe() && $this->memberView->RememberAdmin()))  {

				$html .= "<a href='?".self::$page."=".self::$upload."'>Ladda upp</a>&nbsp;";
			}
				
				$html .= "<a href='?".self::$page."=".self::$Avaliable."'>Ledigt</a>&nbsp;";
			//	$html .= "<a href='?".self::$page."=".self::$registrera."'>Registrera</a>&nbsp;";
				$html .= "<a href='?".self::$page."=".self::$contact."'>Kontakta</a>&nbsp;";
				$html .= "<a href='?".self::$page."=".self::$interest."'>Intresse</a>&nbsp;";
				$html .= "<a href='?".self::$page."=".self::$service."'>Felanmäla</a>&nbsp;";
				$html .= "<a href='?".self::$page."=".self::$HomePage."'>Start Sidan</a>&nbsp;";
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
				# code...
				return $_GET[self::$page];
			}
			return self::$HomePage;
		}

	}