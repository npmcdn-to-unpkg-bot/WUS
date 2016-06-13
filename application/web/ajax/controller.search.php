<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/core/system/ajax.php');
require_once(dirname(dirname(__FILE__)) . "/php/class.search.php");
require_once(dirname(dirname(dirname(__FILE__))) . "/core/system/template.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch($action) {
        case 'search' : 

            $searched = $_POST['searched'];
			echo search($searched);
			break;

        case 'setPage' : 

            $page = $_POST['page'];
            echo setPage($page);
            break;
    }
}

function search($searched = '%') {
    global $bdd;
    global $_TABLES;

    $articlesParPage = 8;

    $content = "";

    $view = new Template(dirname(dirname(__FILE__)) . '/html/article.html');

    if(!is_null($bdd) && !is_null($_TABLES)) {

        // Pré-traitement de la data
        $sql = "";
        if($searched !== "%") {
            $recherche=strtolower($searched);                          // on passe les mots recherchés en minuscules   

            $mots = str_replace("+", " ", trim($recherche));        // on remplace les + par des espaces
            $mots = str_replace("\"", " ", $mots);                  // on remplace les " par des espaces
            $mots = str_replace(",", " ", $mots);                   // on remplace les , par des espaces
            $mots = str_replace(":", " ", $mots);                   // on remplace les : par des espaces
            $tab=explode(" " , $mots);                                // on place les differents mots dans un tableau
            $nb=count($tab);

            $sql="I.title LIKE \"%$tab[0]%\" OR I.description LIKE \"%$tab[0]%\" ";   //on prépare la requête SQL.

            for($i=1 ; $i<$nb; $i++)
            {
                $sql.="OR I.title LIKE \"%$tab[$i]%\"  OR I.description LIKE \"%$tab[$i]%\" ";       // on boucle pour integrer tous les mots dans la requête
            }
        } else {
            $sql = "I.title LIKE '%$search%' OR I.description LIKE '%$search%'";
        }

        // Preparation de la pagination
        $objSearch = new Search($bdd, $_TABLES);
        $articles = $objSearch->getSearch($sql);
        $total = count($articles);
        $nombreDePages = ceil($total / $articlesParPage);
        $pageCourante = 1;

        // Stockage en session des informations de pagination
        if(!isset($_SESSION['pageCourante']))
        {
            $_SESSION['pageCourante'] = $pageCourante;
        } else {

            $pageCourante = $_SESSION['pageCourante'];

            if($pageCourante > $nombreDePages)
            {
                $pageCourante = $nombreDePages;
            }

            if($pageCourante < 1)
            {
                $pageCourante = 1;
            }

            $_SESSION['pageCourante'] = $pageCourante;            
        }

        $start = ($pageCourante - 1) * $articlesParPage;
        $limit = $articlesParPage;

        // Recherche
        $articles = $objSearch->getSearchWithLimit($sql, $start, $limit);

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

            $content .= '<br/><br/><p align="center">Page : '; //Pour l'affichage, on centre la liste des pages
            for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
            {
                 //On va faire notre condition
                 if($i==$pageCourante) //Si il s'agit de la page actuelle...
                 {
                    $content .= " [ $i ] "; 
                 }  
                 else //Sinon...
                 {
                      $content .= " <span class='pagination-search' nbpage='$i'>$i</span> ";
                 }
            }
            $content .= '</p>';

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

function setPage($page = 1) {

    error_log("Set Page $page");
    $_SESSION['pageCourante'] = $page;
}

?>