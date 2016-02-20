<?php

	require('class.login.php');

	global $bdd;
	global $_TABLES;

	$content = "";

    if(!is_null($bdd) && !is_null($_TABLES)) {
        
       	if(isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['pass']) && !empty($_POST['pass'])) {
       		$login = new Login($bdd, $_TABLES);
       		$loggued = $login->getLogin($_POST['login'], $_POST['pass']);

       		if($loggued) {
       			header("Location: /admin");
       			exit;
       		}
       	}
    }
    else {
        error_log("BDD ERROR : " . json_encode($bdd));
        error_log("TABLES ERROR : " . json_encode($_TABLES));
    }
?>