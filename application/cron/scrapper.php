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

                        $url_category = "";

                        if($value_website_category->use_url) {
                            $url_category = $value_website_category->url;
                        }

                        $objItem = new Item($bdd, $_TABLES);

                        $html = file_get_html($url . $url_category);

                        if(!is_null($html)) {

                            foreach ($html->find($config->container . ' ' . $config->item->container) as $value) {

                                $temp['website_category_id'] = $value_website_category->id;
                                $temp['guid'] = substr(md5(microtime(TRUE) * 100000), 0, 5);
                                $temp['url'] = getElement($value->find($config->item->url->html, 0), $config->item->url->element);
                                
                                if($temp['url'][0] == "/") {
                                    $temp['url'] = substr($temp['url'], 1);
                                    $temp['url'] = $value_website->url . $temp['url'];
                                }

                                $temp['title'] = getElement($value->find($config->item->title->html, 0), $config->item->title->element);
                                $temp['width_image'] = getElement($value->find($config->item->width_image->html, 0), $config->item->width_image->element);
                                $temp['height_image'] = getElement($value->find($config->item->height_image->html, 0), $config->item->height_image->element);
                                $temp['image'] = getElement($value->find($config->item->image->html, 0), $config->item->image->element);
                                
                                if($temp['image'][0] == "/") {
                                    $temp['image'] = substr($temp['image'], 1);
                                    $temp['image'] = $value_website->url . $temp['image'];
                                }

                                $temp['alt_image'] = getElement($value->find($config->item->alt_image->html, 0), $config->item->alt_image->element);
                                $temp['description'] = getElement($value->find($config->item->description->html, 0), $config->item->description->element);
                                $temp['date_publication'] = getElement($value->find($config->item->date_publication->html, 0), $config->item->date_publication->element);

                                if(empty($temp['date_publication']) || is_null($temp['date_publication'])) {

                                    $html_inner = file_get_html($temp['url']);

                                    $html_find = $html_inner->find($config->item_inner->date_publication->html, 0);

                                    if(!empty($html_find) && !is_null($html_find)) {

                                        $date_publication = getElement($html_find, $config->item_inner->date_publication->element);
                                        
                                        if(!empty($date_publication) && !is_null($date_publication)) {

                                            $date_publication = setFunction($date_publication, $config->item_inner->date_publication->function);

                                            $dt = DateTime::createFromFormat($config->item_inner->date_publication->format, $date_publication);
                                            $temp['date_publication'] = $dt->format('Y-m-d H:i:s');

                                        } else {
                                            
                                            $dt = new DateTime();
                                            $temp['date_publication'] = $dt->format('Y-m-d H:i:s');
                                        }
                                    } else {
                                        $dt = new DateTime();
                                        $temp['date_publication'] = $dt->format('Y-m-d H:i:s');
                                    }
                                }
                                $temp['author'] = getElement($value->find($config->item->author->html, 0), $config->item->author->element);

                                if(!$objItem->getItemExistByUrl($temp['url'])) {

                                    $data = json_encode($temp);
                                    echo $data;
                                    
                                    $article->setArticle($data);
                                }

                                //die('Scrap one article \n');
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
    }
    else {
        echo("BDD ERROR : " . json_encode($bdd) . "\n");
        echo("TABLES ERROR : " . json_encode($_TABLES) . "\n");
    }

    function getElement($data, $element) {
        switch($element) {
            case "href": {
                return $data->href;
            }

            case "text": {
                return $data->innertext;
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
        switch($function->type) {
            case "explode": {
                return (explode($function->separator, $data)[$function->counter]);
            }
        }
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