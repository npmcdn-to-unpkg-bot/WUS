<?php 
    
    require_once(dirname(dirname(__FILE__)) . "/common/php/class/class.category.php");

    global $bdd;
    global $_TABLES;

    $content = "";

    $view = new Template(dirname(__FILE__) . '/html/category.html');

    if(!is_null($bdd) && !is_null($_TABLES)) {
        $objCategory = new Category($bdd, $_TABLES);
        $categories = $objCategory->getAllCategories();

        if(!is_null($categories)) {

            foreach ($categories as $key => $value) {

                $content .= $view->getView(array(
                    "category_id" => $value->id,
                    "category_name" => mb_strtoupper($value->category)
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