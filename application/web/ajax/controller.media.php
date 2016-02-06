<?php

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch($action) {
        case 'setMediaInCookies' : {
			
			$medias_id = (isset($_POST['medias_id']) ? $_POST['medias_id'] : null);

			echo setMediaInCookies($medias_id);
			break;
		}
    }
}

function setMediaInCookies($medias_id) {
	
	if(isset($medias_id) && count($medias_id) > 0) {

		if(isset($_COOKIE['media_preference'])) {
			unset($_COOKIE['media_preference']);
		}

		$json = json_encode($medias_id);
		setcookie('media_preference', $json, -1, "/");

		return true;
	} else {

        if(isset($_COOKIE['media_preference'])) {
			unset($_COOKIE['media_preference']);
		}

		$json = json_encode($medias_id);
		setcookie('media_preference', $json, -1, "/");
        
		return false;
	}

}
?>