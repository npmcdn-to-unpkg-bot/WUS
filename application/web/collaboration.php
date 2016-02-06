<?php 
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once(dirname(dirname(__FILE__)) . "/common/php/class/class.collaboration.php");

    global $bdd;
    global $_TABLES;

    $content = "";

    if(!is_null($bdd) && !is_null($_TABLES)) {
        $objCollaboration = new Collaboration($bdd, $_TABLES);
        $collaborations = $objCollaboration->getAllCollaborations();

        if($collaborations) {

            $view = new Template(dirname(__FILE__) . '/html/collaboration.html');

            foreach ($collaborations as $key => $value) {

                $content .= $view->getView(array(
                    "title" => $value->collaboration,
                    "url" => $value->url,
                    "image" => $value->image
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