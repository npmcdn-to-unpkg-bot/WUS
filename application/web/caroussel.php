<?php 
    
    require_once(dirname(__FILE__) . "/php/class.caroussel.php");

    global $bdd;
    global $_TABLES;

    $content = "";

    if(!is_null($bdd) && !is_null($_TABLES)) {
        $caroussel = new Caroussel($bdd, $_TABLES);
        $articles_caroussel = $caroussel->getCaroussel();

        $counter_max = count($articles_caroussel);

        if(!is_null($articles_caroussel)) {

            $viewCaroussel = new Template(dirname(__FILE__) . '/html/caroussel.html');

            foreach ($articles_caroussel as $key => $value) {

                $display = '';

                if(($key + 1) > 1)
                {
                    $display = 'display:none;';
                }

                $viewVignetteCaroussel = new Template(dirname(__FILE__) . '/html/vignette_caroussel.html');
                $content .= $viewVignetteCaroussel->getView(array(
                    "url" => '/to/' . $value->guid . '#' . $value->url,
                    "counter" => ($key + 1),
                    "display" => $display,
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

            $content = $viewCaroussel->getView(array(
                    "vignettes" => $content,
                    "counter_max" => $counter_max
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