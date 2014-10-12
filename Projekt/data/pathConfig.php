<?php
	
	// DEFINE CORE PATHS (absolute).
	
	// Define a short for directory separator.
	defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
	// Define a project root path.
	defined('ProjectRootPath') ? null : define('ProjectRootPath', 'C:'.DS.'NewphpLogIn'.DS.'phpLogIn');
	
	// Define helper path.
	defined('HelperPath') ? null : define('HelperPath', ProjectRootPath.DS.'data');
	// Define MVC path.
	defined('ModelPath') ? null : define('ModelPath', ProjectRootPath.DS.'public_html/src/model');
	defined('ViewPath') ? null : define('ViewPath', ProjectRootPath.DS.'public_html/src/view');
	defined('ControllerPath') ? null : define('ControllerPath', ProjectRootPath.DS.'public_html/src/controller');

	// REQUIRE NEEDED FILES BELOW.
	// REQUIRE HELPERS
	require_once(HelperPath.DS.'config.php');

	// require database model (helper)
	require_once(HelperPath.DS.'HTMLView.php');
	require_once(HelperPath.DS.'Database.php');
	require_once(HelperPath.DS.'style.css');
	require_once(HelperPath.DS.'safe.php');
	require_once(HelperPath.DS.'setting.php');
	require_once(HelperPath.DS.'setting.php');
	

	// REQUIRE MODELS
	require_once(ModelPath.DS.'UserModel.php');
	require_once(ModelPath.DS.'User.php');
	require_once(ModelPath.DS.'validation.php');
	require_once(ModelPath.DS.'SessionModel.php');
	require_once(ModelPath.DS.'ImagesRepository.php');
	require_once(ModelPath.DS.'Images.php');
	require_once(ModelPath.DS.'emailContact.php');
	require_once(ModelPath.DS.'emailInterest.php');
	require_once(ModelPath.DS.'emailService.php');

	// REQUIRE VIEWS
	require_once(ViewPath.DS.'LoginView.php');
	require_once(ViewPath.DS.'MemberView.php');
	require_once(ViewPath.DS.'CookieStorage.php');
	require_once(ViewPath.DS.'RegView.php');
	require_once(ViewPath.DS.'available.php');
	require_once(ViewPath.DS.'contact.php');
	require_once(ViewPath.DS.'information.php');
	require_once(ViewPath.DS.'interestView.php');
	require_once(ViewPath.DS.'serviceView.php');
	require_once(ViewPath.DS.'upload.php');
	require_once(ViewPath.DS.'NavigationView.php');
	require_once(ViewPath.DS.'HomePageView.php');

	// REQUIRE CONTROLLERS
	require_once(ControllerPath.DS.'LoginController.php');
	require_once(ControllerPath.DS.'UploadController.php');
	require_once(ControllerPath.DS.'ContactController.php');
	require_once(ControllerPath.DS.'NavigationController.php');