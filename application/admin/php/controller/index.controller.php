<?php

	//require_once(dirname(__FILE__) . "/php/class.admin.php");

    global $bdd;
    global $_TABLES;

    $content = "";

    if(!is_null($bdd) && !is_null($_TABLES)) {
        
        	session_start();
        	if(isset($_SESSION['wus']['admin']['logged']) && $_SESSION['wus']['admin']['logged']) {
        		$view = new Template(dirname(dirname(dirname(__FILE__))) . '/view/index.html');
                $content = $view->getView(array(
                    "login" => $_SESSION['wus']['admin']['login'],
                    "name" => $_SESSION['wus']['admin']['name']
                    ));
                echo $content;
        	}
        	else {
	        	$view = new Template(dirname(dirname(dirname(__FILE__))) . '/view/login.html');
	        	$content = $view->getView(array());
	            echo $content;
        	}
    }
    else {
        error_log("BDD ERROR : " . json_encode($bdd));
        error_log("TABLES ERROR : " . json_encode($_TABLES));
    }

?>