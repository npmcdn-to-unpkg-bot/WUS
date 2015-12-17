<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch($action) {
        case 'setCategoryInCookies' : 
			
			$categories_id = $_POST['categories_id'];

			setCategoryInCookies($categories_id);
			break;
    }
}

function setCategoryInCookies($categories_id) {
	
	if(!is_null($categories_id) && count($categories_id) > 0) {

		if(isset($_COOKIE['category_preference'])) {
			unset($_COOKIE['category_preference']);
		}

		setcookie('category_preference', json_encode($categories_id), -1, "/");

		error_log('Cookies : ' . json_encode($_COOKIE['category_preference']));

		return true;
	} else {
		return false;
	}

}

?>