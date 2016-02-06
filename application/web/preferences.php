<?php 
    
    if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

    require_once(dirname(dirname(__FILE__)) . "/common/php/class/class.category.php");
    require_once(dirname(__FILE__) . "/php/class.preference.php");

    global $bdd;
    global $_TABLES;

    $content = "";

    $view = new Template(dirname(__FILE__) . '/html/category.html');

    if(!is_null($bdd) && !is_null($_TABLES)) {
        $objCategory = new Category($bdd, $_TABLES);
        $categories = $objCategory->getAllCategories();

        if(!is_null($categories)) {

            if(isset($_COOKIE['category_preference'])) {
				unset($_COOKIE['category_preference']);
            }

            $preferences = array();

            if(isset($_SESSION['user_id'])) {

            	$objPreference = new Preference($bdd, $_TABLES);
            	$items = $objPreference->getAllPreferenceByUser($_SESSION['user_id']);

            	if(!is_null($items)) {
            		foreach ($items as $key => $item) {
            			array_push($preferences, $item->category_id);
            		}
            	}

            	$json = json_encode($preferences);
        		setcookie('user_preference', $json, -1, "/");
            }

            foreach ($categories as $key => $value) {

                if($preferences != null) {
                    $checked = (in_array($value->id, $preferences) == true ? 'checked="true"' : '');
                } else {
                    $checked = '';
                }

                $content .= $view->getView(array(
                    "category_id" => $value->id,
                    "category_name" => mb_strtoupper($value->category),
                    "checked" => $checked
                    ));
            }

            echo $content;
        }
        else {
            // 404
            echo "404 Not Found";
        }
    }
    else {
        error_log("BDD ERROR : " . json_encode($bdd));
        error_log("TABLES ERROR : " . json_encode($_TABLES));
    }
?>