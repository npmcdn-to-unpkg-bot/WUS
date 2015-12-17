<?php
session_start();

$adminPath 	= dirname(__FILE__)."/../../"; 	//admin folder
$viewPath 	= "view/"; 		//view folder

//some security check: check admin session
if(!isset($_SESSION['wus']['admin']['logged']) || !$_SESSION['wus']['admin']['logged']) {
	die("Module Website Subscription : accès refusé ! ");
}

require_once "config.php";
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/core/system/ajax.php');

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="/application/css/library/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="/application/admin/modules/website_subscription/css/menu.css">
	<link rel="stylesheet" type="text/css" href="/application/admin/modules/website_subscription/css/website_subscription.css">
	<title>WUS - Module Website Subscription</title>
</head>
<body>

<?php require_once $viewPath . "menu.html"; ?>
<?php require_once $viewPath . "website_subscription.html"; ?>

<script type="text/javascript" src="/application/js/library/jquery.js"></script>
<script type="text/javascript" src="/application/js/library/jquery-ui.min.js"></script>
<script type="text/javascript" src="/application/js/library/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/application/js/library/jquery.uploadfile.min.js"></script>

<script type="text/javascript" src="/application/admin/modules/website_subscription/js/menu.js"></script>
<script type="text/javascript" src="/application/admin/modules/website_subscription/js/website_subscription.js"></script>

</body>
</html>