<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/core/system/ajax.php');
require_once(dirname(dirname(__FILE__)) . "/php/class.rss.php");
require_once(dirname(dirname(dirname(__FILE__))) . "/core/system/template.php");

function getFluxRss() {
    global $bdd;
    global $_TABLES;
    $ajax = new Ajax();

    $flux = "";
    $flux_items = "";

    $view_rss = new Template(dirname(dirname(__FILE__)) . '/html/rss.html');
    $view_item = new Template(dirname(dirname(__FILE__)) . '/html/rss-item.html');

    if(!is_null($bdd) && !is_null($_TABLES)) {
        $objRss = new Rss($bdd, $_TABLES);
        $items = $objRss->getAll();

        if(!is_null($items)) {

            foreach ($items as $key => $value) {


                $flux_items .= $view_item->getView(array(
                    "guid" => 'http://' . $_SERVER['HTTP_HOST'] . '/to/' . $value->guid . '#' . $value->url,
                    "title" => $value->title,
                    "url" => 'http://' . $_SERVER['HTTP_HOST'] . '/to/' . $value->guid . '#' . $value->url,
                    "description" => $value->description,
                    "date_publication" => (date("D, d M Y H:i:s", strtotime($value->date_publication)) . ' +0200')
                    ));
            }

            $flux = $view_rss->getView(array(
                    "flux_rss" => 'http://' . $_SERVER['HTTP_HOST'] . $ajax->env->flux_rss,
                    "title_site" => $ajax->env->title_site,
                    "url_site" => 'http://' . $_SERVER['HTTP_HOST'],
                    "description_site" => $ajax->env->description_site,
                    "items" => $flux_items,
                    "date_publication_site" => (date("D, d M Y H:i:s", strtotime("now")) . ' +0200')
                    ));

            $fp = fopen(dirname(dirname(dirname(dirname(__FILE__)))) . "/rss.xml", 'w+');
            fputs($fp, html_entity_decode(htmlspecialchars_decode($flux)));
            fclose($fp);
            return file_get_contents(dirname(dirname(dirname(dirname(__FILE__)))) . "/rss.xml");
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