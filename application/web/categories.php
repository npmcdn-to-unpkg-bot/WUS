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

            $category_preference = null;

            if(isset($_COOKIE['category_preference'])) {

                $category_preference = json_decode(stripcslashes($_COOKIE['category_preference']), true);

                if(is_null($category_preference)) {
                    $category_preference = '';
                }
            }

            foreach ($categories as $key => $value) {

                if(!is_null($category_preference) && !empty($category_preference)) {
                    $checked = (in_array($value->id, $category_preference) == true ? 'checked="true"' : '');
                } else if(empty($category_preference)) {
                    $checked = '';
                } else {
                    $checked = 'checked="true"';
                }

                $content .= $view->getView(array(
                    "category_id" => $value->id,
                    "category_name" => mb_strtoupper($value->category),
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