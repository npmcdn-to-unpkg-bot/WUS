<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/core/system/ajax.php');
require_once(dirname(dirname(__FILE__)) . "/php/class.last_article.php");
require_once(dirname(dirname(dirname(__FILE__))) . "/core/system/template.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch($action) {
        case 'lastArticle' : 
			echo lastArticle();
			break;
    }
}

function lastArticle() {
    global $bdd;
    global $_TABLES;

    $content = "";

    $view = new Template(dirname(dirname(__FILE__)) . '/html/article.html');

    if(!is_null($bdd) && !is_null($_TABLES)) {
        $objLastArticle = new LastArticle($bdd, $_TABLES);
        $articles = $objLastArticle->getLastArticles();

        if(!is_null($articles)) {

            foreach ($articles as $key => $value) {

                $temp_subscription = '';

                if(isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == '1' && isset($_SESSION['user_subscription'])) {
                    if(in_array($value->website_id, $_SESSION['user_subscription'])) {
                        $temp_subscription = "<div class='unsubscription' website_id='%%website_id%%'></div>";
                    } else {
                        $temp_subscription = "<div class='subscription' website_id='%%website_id%%'></div>";
                    }
                }

                $content .= $view->getView(array(
                    "url" => '/to/' . $value->guid . '#' . $value->url,
                    "title" => $value->title,
                    "width_image" => $value->width_image,
                    "height_image" => $value->height_image,
                    "image" => $value->image,
                    "alt_image" => $value->alt_image,
                    "description" => $value->description,
                    "logo_site" => $value->logo,
                    "alt_logo_site" => $value->website,
                    "title_site" => $value->website,
                    "subscription" => $temp_subscription,
                    "website_id" => $value->website_id
                    ));
            }

            return $content;
        }
        else {
            // 404
            return "404 Not Found";
        }
    }
    else {
        error_log("BDD ERROR : " . json_encode($bdd));
        error_log("TABLES ERROR : " . json_encode($_TABLES));
    }
}

?>