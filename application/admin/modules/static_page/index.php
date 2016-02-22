<?php
session_start();

$adminPath 	= dirname(__FILE__)."/../../"; 	//admin folder
$viewPath 	= "view/"; 		//view folder

//some security check: check admin session
if(!isset($_SESSION['wus']['admin']['logged']) || !$_SESSION['wus']['admin']['logged']) {
	die("Module Static Page : accès refusé ! ");
}

require_once "config.php";
require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/core/system/ajax.php');

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="/application/css/library/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="/application/admin/modules/static_page/css/static_page.css">
	<title>WUS - Module Static Page</title>
</head>
<body>

<script type="text/javascript" src="/application/js/library/jquery.js"></script>
<script type="text/javascript" src="/application/js/library/jquery-ui.min.js"></script>
<script type="text/javascript" src="/application/js/library/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/application/js/library/jquery.uploadfile.min.js"></script>
<script type="text/javascript" src="/application/js/library/ckeditor/ckeditor.js"></script>

<?php require_once $viewPath . "static_page.html"; ?>

<script type="text/javascript" src="/application/admin/modules/static_page/js/static_page.js"></script>

</body>
</html>