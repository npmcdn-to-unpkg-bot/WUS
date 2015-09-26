<?php 
    
    require_once(dirname(dirname(__FILE__)) . "/common/php/class/class.article.php");
    //require_once(dirname(__FILE__) . "/php/class.article.php");

    global $bdd;
    global $_TABLES;

    $content = "";

    $view = new Template(dirname(__FILE__) . '/html/article.html');

    if(!is_null($bdd) && !is_null($_TABLES)) {
        $article = new Article($bdd, $_TABLES);
        $articles = $article->getArticles();

        if(!is_null($articles)) {

            foreach ($articles as $key => $value) {

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
                    "title_site" => $value->website
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