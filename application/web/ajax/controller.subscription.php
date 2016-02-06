<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/core/system/ajax.php');
require_once(dirname(dirname(dirname(__FILE__))) . "/common/php/class/class.website_subscription.php");
require_once(dirname(dirname(dirname(__FILE__))) . "/common/php/class/class.website.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch($action) {

        case 'subscriptionList' : {

            echo subscriptionList();
            break;
        }

        case 'subscription' : {
			
			$website_id = (isset($_POST['website_id']) ? $_POST['website_id'] : null);

			echo subscription($website_id);
			break;
		}

        case 'unsubscription' : {
            
            $website_id = (isset($_POST['website_id']) ? $_POST['website_id'] : null);

            echo unsubscription($website_id);
            break;
        }
    }
}

function subscriptionList() {
    global $bdd;
    global $_TABLES;

    $content = "";

    $view = new Template(dirname(dirname(__FILE__)) . '/html/media.html');

    if(!is_null($bdd) && !is_null($_TABLES)) {
        
        if(isset($_SESSION['user_id'])) {

            $user_id = $_SESSION['user_id'];

            $objWebsiteSubscription = new WebsiteSubscription($bdd, $_TABLES);
            $website_subscriptions = $objWebsiteSubscription->getAllWebsiteSubscriptionsByUser($user_id);

            if(!is_null($website_subscriptions)) {

                $objWebsite = new Website($bdd, $_TABLES);

                foreach ($website_subscriptions as $key => $value) {

                    $website = $objWebsite->getData($value->website_id);

                    if(!is_null($website)) {

                        $temp_subscription = "<div class='unsubscription' website_id='%%website_id%%'></div>";

                        $content .= $view->getView(array(
                            "url" => $website->url,
                            "title" => $website->website,
                            "logo_site" => $website->logo,
                            "alt_logo_site" => $website->website,
                            "title_site" => $website->website,
                            "subscription" => $temp_subscription,
                            "website_id" => $website->id
                            ));

                    }
                }

                return $content;
            }
            else {
                // 404
                return "404 Not Found";
            }

        } else {
            // 404
            return "404 Not Found";
        }
    }
    else {
        error_log("BDD ERROR : " . json_encode($bdd));
        error_log("TABLES ERROR : " . json_encode($_TABLES));
    }
}

function subscription($website_id) {
	global $bdd;
    global $_TABLES;

    if(!is_null($bdd) && !is_null($_TABLES)) {
        
    	if(isset($_SESSION['user_id'])) {

    		$user_id = $_SESSION['user_id'];

            array_push($_SESSION['user_subscription'], $website_id);

    		$objWebsiteSubscription = new WebsiteSubscription($bdd, $_TABLES);
        	$objWebsiteSubscription->createWebsiteSubscription($user_id, $website_id);

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

function unsubscription($website_id) {
    global $bdd;
    global $_TABLES;

    if(!is_null($bdd) && !is_null($_TABLES)) {
        
        if(isset($_SESSION['user_id'])) {

            $user_id = $_SESSION['user_id'];
            //array_push($_SESSION['user_subscription'], $website_id);
            // Remplacer par une suppression dans le tableau directement
            unset($_SESSION['user_subscription']);

            $objWebsiteSubscription = new WebsiteSubscription($bdd, $_TABLES);
            $objWebsiteSubscription->deleteWebsiteSubscriptionByUserAndWebsite($user_id, $website_id);

            $website_subscriptions = $objWebsiteSubscription->getAllWebsiteSubscriptionsByUser($_SESSION['user_id']);

            $temp = array();
            if($website_subscriptions) {

                foreach ($website_subscriptions as $key => $value) {
                    array_push($temp, $value->website_id);
                }
            }
            $_SESSION['user_subscription'] = $temp;

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