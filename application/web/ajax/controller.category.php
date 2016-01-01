<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/core/system/ajax.php');
require_once(dirname(dirname(__FILE__)) . "/php/class.preference.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch($action) {
        case 'setCategoryInCookies' : {
			
			$categories_id = (isset($_POST['categories_id']) ? $_POST['categories_id'] : null);

			echo setCategoryInCookies($categories_id);
			break;
		}

		case 'setCategoryInBdd' : {
			
			$categories_id = (isset($_POST['categories_id']) ? $_POST['categories_id'] : null);

			echo setCategoryInBdd($categories_id);
			break;
		}
    }
}

function setCategoryInCookies($categories_id) {
	
	if(isset($categories_id) && count($categories_id) > 0) {

		if(isset($_COOKIE['category_preference'])) {
			unset($_COOKIE['category_preference']);
		}

		$json = json_encode($categories_id);
		setcookie('category_preference', $json, -1, "/");

		return true;
	} else {
		return false;
	}

}

function setCategoryInBdd($categories_id) {
	global $bdd;
    global $_TABLES;

    if(!is_null($bdd) && !is_null($_TABLES)) {
        
    	if(isset($_SESSION['user_id'])) {

    		$user_id = $_SESSION['user_id'];

    		$objPreference = new Preference($bdd, $_TABLES);
        	$objPreference->removeAllPreferenceByUser($user_id);

        	if(count($categories_id) > 0) {
        		foreach ($categories_id as $key => $category_id) {
        			
        			$objPreference->addPreferenceByUser($user_id, $category_id);

        		}
        	}

        	return true;

    	} else {
    		return false;
    	}
    }
    else {
        error_log("BDD ERROR : " . json_encode($bdd));
        error_log("TABLES ERROR : " . json_encode($_TABLES));
    }
}

?>