<?php 
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once(dirname(dirname(__FILE__)) . "/common/php/class/class.website.php");

    global $bdd;
    global $_TABLES;

    $content = "";

    $view = new Template(dirname(__FILE__) . '/html/website.html');

    if(!is_null($bdd) && !is_null($_TABLES)) {
        $objWebsite = new Website($bdd, $_TABLES);
        $websites = $objWebsite->getAllWebsites();

        if(!is_null($websites)) {

            foreach ($websites as $key => $value) {

                if(isset($_COOKIE['media_preference'])) {

                    $website_preference = json_decode(stripcslashes($_COOKIE['media_preference']), true);

                    if(!is_null($website_preference) && !empty($website_preference)) {
                        $checked = (in_array($value->id, $website_preference) == true ? 'checked="true"' : '');
                    } else {
                        $checked = '';
                    }
                }
                else {
                    $checked = 'checked="true"';
                }

                $content .= $view->getView(array(
                    "website_id" => $value->id,
                    "website_name" => mb_strtoupper($value->website),
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