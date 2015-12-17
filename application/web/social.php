<?php 
    
    require_once(dirname(dirname(__FILE__)) . "/common/php/class/class.system_preference.php");

    global $bdd;
    global $_TABLES;

    $content = "";

    $view = new Template(dirname(__FILE__) . '/html/social.html');

    if(!is_null($bdd) && !is_null($_TABLES)) {
        $objSystemPreference = new SystemPreference($bdd, $_TABLES);
        $system_preference = $objSystemPreference->getSystemPreference();

        if(!is_null($system_preference)) {

            $content = $view->getView(array(
                    "url_facebook" => $system_preference->url_facebook,
                    "url_instagram" => $system_preference->url_instagram,
                    "url_twitter" => $system_preference->url_twitter
                    ));

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