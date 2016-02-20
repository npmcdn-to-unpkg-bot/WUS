<?php 
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once(dirname(dirname(__FILE__)) . "/common/php/class/class.website.php");

    global $bdd;
    global $_TABLES;

    $content = "";

    $view = new Template(dirname(__FILE__) . '/html/media-list.html');

    if(isset($_SESSION['user_id'])) {

        if(!is_null($bdd) && !is_null($_TABLES)) {
            $objWebsite = new Website($bdd, $_TABLES);
            $websites = $objWebsite->getAllWebsitesNoSubscript($_SESSION['user_id']);

            if(!is_null($websites)) {

                foreach ($websites as $key => $value) {

                    $temp_subscription = "<div class='subscription' website_id='%%website_id%%'></div>";

                    $content .= $view->getView(array(
                        "url" => $value->url,
                        "title" => $value->website,
                        "subscription" => $temp_subscription,
                        "website_id" => $value->id
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

    }
    
?>