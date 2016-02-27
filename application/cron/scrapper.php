<?php
	// This is the scrapper of WUSS
	// Author : Quentin BELOT

    require_once(dirname(dirname(__FILE__)) . "/common/php/class/class.website.php");
    require_once(dirname(dirname(__FILE__)) . "/common/php/class/class.website_category.php");
    require_once(dirname(dirname(__FILE__)) . "/common/php/class/class.item.php");
    require_once(dirname(dirname(__FILE__)) . "/common/php/class/class.article.php");
	require_once(dirname(dirname(__FILE__)) . "/common/php/tools/simple_html_dom.php");

	$host = 'localhost';
	$database = 'wus';
	$username = 'root';
	$password = 'root';
	$bdd = getConnection();
    $_TABLES = null;


    if(!is_null($bdd)) $_TABLES = getStructure();
    else echo "Connection BDD Error \n";

    if(!is_null($bdd) && !is_null($_TABLES)) {
        
        set_time_limit(0);

        $website = new Website($bdd, $_TABLES);
        $websites = $website->getWebsites();

        if(!is_null($websites)) {

            foreach ($websites as $key_website => $value_website) {
                $website_category = new WebsiteCategory($bdd, $_TABLES);
                $website_categories = $website_category->getWebsiteCategories($value_website->id);

                $url = $value_website->url;
                $file = $value_website->file;

                // Try to load json config
                $config = null;
                $json = file_get_contents(dirname(dirname(dirname(__FILE__))) . '/' . $file); 

                if ($json !== false) { // if Valid Config

                    $config = json_decode($json);
                    
                }
                else { // Invalid Config
                    
                    echo "Website File Not Found \n";
                }

                if(!is_null($website_categories)) {

                    foreach ($website_categories as $key_website_category => $value_website_category) {
                        $article = new Article($bdd, $_TABLES);
                        $objItem = new Item($bdd, $_TABLES);

                        $url_category = "";
                        $url_pagination = "";
                        $url_temp_pagination = "";
                        $nb_max_pagination = 100; // CONSTANTE A VERIFIER

                        if($value_website_category->use_url) {
                            $url_category = $value_website_category->url;
                        }

                        if($value_website_category->use_pagination) {
                            $url_pagination = $value_website_category->url_pagination;

                            for ($nb_page = 0; $nb_page < $nb_max_pagination; $nb_page++) {
                                
                                if($nb_page != 0) {
                                    $url_temp_pagination = str_replace("%%nb_page%%", $nb_page, $url_pagination);
                                }

                                $file_headers = @get_headers($url . $url_category . $url_temp_pagination);
                                if($file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.1 502 Bad Gateway') {
                                    
                                    // 404 lors de la recherche par pagination
                                    // Donc break de la boucle de pagination
                                    break;

                                }
                                else {

                                    $html = file_get_html($url . $url_category . $url_temp_pagination);

                                    if(!is_null($html)) {

                                        $data = $html->find($config->container->html . ' ' . $config->container->item->html);

                                        if(!is_null($data)) {

                                            foreach ($data as $value) {

                                                $temp['website_category_id'] = $value_website_category->id;
                                                $temp['guid'] = substr(md5(microtime(TRUE) * 100000), 0, 5);
                                                $temp['url'] = getElement($value->find($config->container->item->url->html, $config->container->item->url->counter), $config->container->item->url->element);
                                                
                                                if($temp['url'][0] == "/" && $temp['url'][1] != "/") {
                                                    $temp['url'] = substr($temp['url'], 1);
                                                    $temp['url'] = $value_website->url . $temp['url'];
                                                }

                                                $temp['title'] = getElement($value->find($config->container->item->title->html, $config->container->item->title->counter), $config->container->item->title->element);
                                                $temp['width_image'] = getElement($value->find($config->container->item->width_image->html, $config->container->item->width_image->counter), $config->container->item->width_image->element);
                                                $temp['height_image'] = getElement($value->find($config->container->item->height_image->html, $config->container->item->height_image->counter), $config->container->item->height_image->element);
                                                $temp['image'] = getElement($value->find($config->container->item->image->html, $config->container->item->image->counter), $config->container->item->image->element);
                                                
                                                if($temp['image'][0] == "/" && $temp['image'][1] != "/") {
                                                    $temp['image'] = substr($temp['image'], 1);
                                                    $temp['image'] = $value_website->url . $temp['image'];
                                                }

                                                $temp['alt_image'] = getElement($value->find($config->container->item->alt_image->html, $config->container->item->alt_image->counter), $config->container->item->alt_image->element);
                                                $temp['description'] = getElement($value->find($config->container->item->description->html, $config->container->item->description->counter), $config->container->item->description->element);
                                                $temp['date_publication'] = getElement($value->find($config->container->item->date_publication->html, $config->container->item->date_publication->counter), $config->container->item->date_publication->element);

                                                if(empty($temp['date_publication']) || is_null($temp['date_publication'])) {

                                                    $html_inner = file_get_html($temp['url']);

                                                    $html_find = $html_inner->find($config->container->item_inner->date_publication->html, $config->container->item_inner->date_publication->counter);

                                                    if(!empty($html_find) && !is_null($html_find)) {

                                                        $date_publication = getElement($html_find, $config->container->item_inner->date_publication->element);
                                                        
                                                        if(!empty($date_publication) && !is_null($date_publication)) {

                                                            error_log($date_publication);

                                                            $date_publication = setFunction($date_publication, $config->container->item_inner->date_publication->function);

                                                            error_log($date_publication);

                                                            $date_publication = preFormatMonthDate($date_publication);

                                                            error_log($date_publication);

                                                            $date_publication = ltrim($date_publication, $config->container->item_inner->date_publication->prev);

                                                            error_log($date_publication);

                                                            $date_publication = rtrim($date_publication, $config->container->item_inner->date_publication->next);

                                                            error_log($date_publication);

                                                            $date_publication = trim($date_publication);

                                                            error_log($date_publication);

                                                            $dt = DateTime::createFromFormat($config->container->item_inner->date_publication->format, $date_publication);
                                                            
                                                            if(!is_null($dt) || !empty($dt)) {

                                                                $temp['date_publication'] = $dt->format('Y-m-d H:i:s');
                                                                
                                                            }

                                                        } else {
                                                            
                                                            $dt = new DateTime();
                                                            $temp['date_publication'] = $dt->format('Y-m-d H:i:s');
                                                        }
                                                    } else {
                                                        $dt = new DateTime();
                                                        $temp['date_publication'] = $dt->format('Y-m-d H:i:s');
                                                    }
                                                }
                                                $temp['author'] = getElement($value->find($config->container->item->author->html, $config->container->item->author->counter), $config->container->item->author->element);

                                                if(!$objItem->getItemExistByUrl($temp['url'])) {

                                                    $data = json_encode($temp);
                                                    echo $data;
                                                    
                                                    $article->setArticle($data);
                                                }

                                                //die('Scrap one article \n');
                                            }
                                        } else {
                                            // 404 lors de la recherche par pagination
                                            // Donc break de la boucle de pagination
                                            break;
                                        }
                                    } else {
                                        // 404 lors de la recherche par pagination
                                        // Donc break de la boucle de pagination
                                        break;
                                    }
                                }
                            }
                        } else {
                            // Si on utilise pas de pagination

                            $html = file_get_html($url . $url_category);

                            if(!is_null($html)) {

                                $data = $html->find($config->container->html . ' ' . $config->container->item->html);

                                if(!is_null($data)) {
                                    foreach ($data as $value) {

                                        $temp['website_category_id'] = $value_website_category->id;
                                        $temp['guid'] = substr(md5(microtime(TRUE) * 100000), 0, 5);
                                        $temp['url'] = getElement($value->find($config->container->item->url->html, $config->container->item->url->counter), $config->container->item->url->element);
                                        
                                        if($temp['url'][0] == "/" && $temp['url'][1] != "/") {
                                            $temp['url'] = substr($temp['url'], 1);
                                            $temp['url'] = $value_website->url . $temp['url'];
                                        }

                                        $temp['title'] = getElement($value->find($config->container->item->title->html, $config->container->item->title->counter), $config->container->item->title->element);
                                        $temp['width_image'] = getElement($value->find($config->container->item->width_image->html, $config->container->item->width_image->counter), $config->container->item->width_image->element);
                                        $temp['height_image'] = getElement($value->find($config->container->item->height_image->html, $config->container->item->height_image->counter), $config->container->item->height_image->element);
                                        $temp['image'] = getElement($value->find($config->container->item->image->html, $config->container->item->image->counter), $config->container->item->image->element);
                                        
                                        if($temp['image'][0] == "/" && $temp['image'][1] != "/") {
                                            $temp['image'] = substr($temp['image'], 1);
                                            $temp['image'] = $value_website->url . $temp['image'];
                                        }

                                        $temp['alt_image'] = getElement($value->find($config->container->item->alt_image->html, $config->container->item->alt_image->counter), $config->container->item->alt_image->element);
                                        $temp['description'] = getElement($value->find($config->container->item->description->html, $config->container->item->description->counter), $config->container->item->description->element);
                                        $temp['date_publication'] = getElement($value->find($config->container->item->date_publication->html, $config->container->item->date_publication->counter), $config->container->item->date_publication->element);

                                        if(empty($temp['date_publication']) || is_null($temp['date_publication'])) {

                                            $html_inner = file_get_html($temp['url']);

                                            $html_find = $html_inner->find($config->container->item_inner->date_publication->html, $config->container->item_inner->date_publication->counter);

                                            if(!empty($html_find) && !is_null($html_find)) {

                                                $date_publication = getElement($html_find, $config->container->item_inner->date_publication->element);
                                                
                                                if(!empty($date_publication) && !is_null($date_publication)) {

                                                    error_log($date_publication);

                                                    $date_publication = setFunction($date_publication, $config->container->item_inner->date_publication->function);

                                                    error_log($date_publication);

                                                    $date_publication = preFormatMonthDate($date_publication);

                                                    error_log($date_publication);

                                                    $date_publication = ltrim($date_publication, $config->container->item_inner->date_publication->prev);

                                                    error_log($date_publication);

                                                    $date_publication = rtrim($date_publication, $config->container->item_inner->date_publication->next);

                                                    error_log($date_publication);

                                                    $date_publication = trim($date_publication);

                                                    error_log($date_publication);

                                                    $dt = DateTime::createFromFormat($config->container->item_inner->date_publication->format, $date_publication);
                                                    
                                                    if(!is_null($dt) || !empty($dt)) {

                                                        $temp['date_publication'] = $dt->format('Y-m-d H:i:s');
                                                        
                                                    }

                                                } else {
                                                    
                                                    $dt = new DateTime();
                                                    $temp['date_publication'] = $dt->format('Y-m-d H:i:s');
                                                }
                                            } else {
                                                $dt = new DateTime();
                                                $temp['date_publication'] = $dt->format('Y-m-d H:i:s');
                                            }
                                        }
                                        $temp['author'] = getElement($value->find($config->container->item->author->html, $config->container->item->author->counter), $config->container->item->author->element);

                                        if(!$objItem->getItemExistByUrl($temp['url'])) {

                                            $data = json_encode($temp);
                                            echo $data;
                                            
                                            $article->setArticle($data);
                                        }

                                        //die('Scrap one article \n');
                                    }
                                } else {
                                    // 404 lors de la recherche classique
                                    // Donc continue de la boucle de categorie
                                    continue;
                                }
                            } else {
                                // 404 lors de la recherche classique
                                // Donc continue de la boucle de categorie
                                continue;
                            }
                        }
                    }
                }
                else {
                    echo "Website Categories Not Found For " . $url . "\n";
                }
            }
        }
        else {
            echo "Websites Not Found \n";
        }

        set_time_limit(300);
    }
    else {
        echo("BDD ERROR : " . json_encode($bdd) . "\n");
        echo("TABLES ERROR : " . json_encode($_TABLES) . "\n");
    }

    function preFormatMonthDate($data)
    {
        $temp = $data;

        $temp = strtolower($temp);

        // JANVIER

        if (strpos($temp, 'janvier') !== false) {
            $temp = str_replace('janvier', 'January', $temp);
            return $temp;
        }

        if (strpos($temp, 'jan') !== false) {
            $temp = str_replace('jan', 'Jan', $temp);
            return $temp;
        }

        // FEVRIER

        if (strpos($temp, 'fevrier') !== false) {
            $temp = str_replace('fevrier', 'February', $temp);
            return $temp;
        }

        if (strpos($temp, 'février') !== false) {
            $temp = str_replace('février', 'February', $temp);
            return $temp;
        }

        if (strpos($temp, 'fev') !== false) {
            $temp = str_replace('fev', 'Feb', $temp);
            return $temp;
        }

        if (strpos($temp, 'fév') !== false) {
            $temp = str_replace('fév', 'Feb', $temp);
            return $temp;
        }

        // MARS

        if (strpos($temp, 'mars') !== false) {
            $temp = str_replace('mars', 'March', $temp);
            return $temp;
        }

        if (strpos($temp, 'mar') !== false) {
            $temp = str_replace('mar', 'Mar', $temp);
            return $temp;
        }

        // AVRIL

        if (strpos($temp, 'avril') !== false) {
            $temp = str_replace('avril', 'April', $temp);
            return $temp;
        }

        if (strpos($temp, 'avr') !== false) {
            $temp = str_replace('avr', 'Apr', $temp);
            return $temp;
        }

        // MAI

        if (strpos($temp, 'mai') !== false) {
            $temp = str_replace('mai', 'May', $temp);
            return $temp;
        }

        // JUIN

        if (strpos($temp, 'juin') !== false) {
            $temp = str_replace('juin', 'June', $temp);
            return $temp;
        }

        if (strpos($temp, 'jun') !== false) {
            $temp = str_replace('jun', 'Jun', $temp);
            return $temp;
        }

        // JUILLET

        if (strpos($temp, 'juillet') !== false) {
            $temp = str_replace('juillet', 'July', $temp);
            return $temp;
        }

        if (strpos($temp, 'jui') !== false) {
            $temp = str_replace('jui', 'Jul', $temp);
            return $temp;
        }

        // AOUT

        if (strpos($temp, 'aout') !== false) {
            $temp = str_replace('aout', 'August', $temp);
            return $temp;
        }

        if (strpos($temp, 'août') !== false) {
            $temp = str_replace('août', 'August', $temp);
            return $temp;
        }

        if (strpos($temp, 'aou') !== false) {
            $temp = str_replace('aou', 'Aug', $temp);
            return $temp;
        }

        if (strpos($temp, 'aoû') !== false) {
            $temp = str_replace('aoû', 'Aug', $temp);
            return $temp;
        }

        // SEPTEMBRE

        if (strpos($temp, 'septembre') !== false) {
            $temp = str_replace('septembre', 'September', $temp);
            return $temp;
        }

        if (strpos($temp, 'sep') !== false) {
            $temp = str_replace('sep', 'Sep', $temp);
            return $temp;
        }

        // OCTOBRE

        if (strpos($temp, 'octobre') !== false) {
            $temp = str_replace('octobre', 'October', $temp);
            return $temp;
        }

        if (strpos($temp, 'oct') !== false) {
            $temp = str_replace('oct', 'Oct', $temp);
            return $temp;
        }

        // NOVEMBRE

        if (strpos($temp, 'novembre') !== false) {
            $temp = str_replace('novembre', 'November', $temp);
            return $temp;
        }

        if (strpos($temp, 'nov') !== false) {
            $temp = str_replace('nov', 'Nov', $temp);
            return $temp;
        }

        // DECEMBER

        if (strpos($temp, 'decembre') !== false) {
            $temp = str_replace('decembre', 'December', $temp);
            return $temp;
        }

        if (strpos($temp, 'décembre') !== false) {
            $temp = str_replace('décembre', 'December', $temp);
            return $temp;
        }

        if (strpos($temp, 'dec') !== false) {
            $temp = str_replace('dec', 'Dec', $temp);
            return $temp;
        }

        if (strpos($temp, 'déc') !== false) {
            $temp = str_replace('déc', 'Dec', $temp);
            return $temp;
        }

        return $data;
    }

    function getElement($data, $element) {
        switch($element) {
            case "href": {
                return $data->href;
            }

            case "text": {
                return $data->innertext;
            }

            case "outertext": {
                return $data->outertext;
            }

            case "innertext": {
                return $data->innertext;
            }

            case "plaintext": {
                return $data->plaintext;
            }

            case "src": {
                return $data->src;
            }

            case "title": {
                return $data->title;
            }

            case "width": {
                return $data->width;
            }

            case "height": {
                return $data->height;
            }

            case "alt": {
                return $data->alt;
            }
        }
    }

    function setFunction($data, $function) {

        $temp = $data;

        $actions = explode(',', $function->type);

        foreach ($actions as $key => $action) {
            
            $type = explode('%', $action);

            switch($type[0]) {
                case "explode": {

                    $aux = explode($type[1], $temp);

                    if(count($aux) > 0) {
                        $temp = $aux[$type[2]];
                    }
                }
            }
        }

        return $temp;
    }

    function getConnection(){
        
        $bdd = null;
        global $host;
        global $database;
        global $username;
        global $password;

        /*echo $bdd . "\n";
        echo $host . "\n";
        echo $database . "\n";
        echo $username . "\n";
        echo $password . "\n";*/

        try {
            $bdd = new PDO('mysql:host='.$host.
                                        ';dbname='.$database, 
                                        $username, 
                                        $password, 
                                        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                                            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            return $bdd;
        }
        catch(PDOException $e) {
            
            echo $e->getMessage() . "\n";

            return null;
        }
    }

    function getStructure(){
        
        global $bdd;
        global $database;

        $_TABLES = [];

        try
        {
            $req = $bdd->prepare("SELECT table_name FROM information_schema.tables WHERE table_schema = :database AND table_type = 'BASE TABLE'");
            $req->bindValue('database', $database, PDO::PARAM_STR);
            $req->execute();
            $tables = $req->fetchAll(PDO::FETCH_OBJ);
            $req->closeCursor();
        }
        catch (PDOException $e)
        {
            echo('Erreur : ' . $e->getMessage() . "\n");
            die('Erreur : ' . $e->getMessage());
        }

        if($tables != false)
        {
            //error_log('TABLES OK');

            foreach ($tables as $key => $value) 
            {
                //error_log('DB TABLE : ' . $value->table_name . "\n");

                $prefix = strtolower(explode('_', $value->table_name)[0]);
                $table = substr($value->table_name, strlen($prefix) + 1);

                //error_log('DB PREFIX TABLE : ' . $prefix . "\n");
                //error_log('DB EXPLODE TABLE : ' . $table . "\n");

                $array_table = explode("__", $table);

                //error_log('COUNT TABLE : ' . count($array_table) . "\n");

                if(count($array_table) < 2)
                {
                    $result = '';
                    $temp = $array_table[0];

                    foreach (explode('_', $temp) as $key2 => $value2) 
                    {
                        $result .= ucfirst(strtolower($value2));
                    }

                    $_TABLES["$prefix"]["$result"] = $value->table_name;

                    //error_log('$_TABLES["' . $prefix . '"]["' . $result . '"] = ' . $value->table_name . "\n");
                }
                else
                {
                    $result = '';

                    foreach ($array_table as $key2 => $value2) 
                    {
                        $temp = $value2;

                        foreach (explode('_', $temp) as $key3 => $value3) 
                        {
                            $result .= ucfirst(strtolower($value3));
                        }

                        if($key2 < count($array_table) - 1) $result .= '_';
                    }

                    $_TABLES["$prefix"]["$result"] = $value->table_name;

                    //error_log('$_TABLES["' . $prefix . '"]["' . $result . '"] = ' . $value->table_name . "\n");
                }           
            }
        }
        else
        {
            //error_log('TABLES ERROR');
        }

        return $_TABLES;
    }
?>