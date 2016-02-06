<?php

	require_once(dirname(__FILE__) . "/php/class.document.php");

    global $bdd;
    global $_TABLES;

    $content = "";

    if(!is_null($bdd) && !is_null($_TABLES)) {
        $objDocument = new Document($bdd, $_TABLES);
        $documents = $objDocument->getAllDocuments();

        if(!is_null($documents)) {

            $view = new Template(dirname(__FILE__) . '/html/document.html');

            foreach ($documents as $key => $value) {

                $temp = $view;
                $content .= $temp->getView(array(
                    "document_url" => '/legale/' . $value->url,
                    "document_id" => $value->id,
                    "document_title" => $value->title
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