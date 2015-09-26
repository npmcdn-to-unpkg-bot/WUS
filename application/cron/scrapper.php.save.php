<?php
	// This is the scrapper of WUSS
	// Author : Quentin BELOT

	require_once(dirname(__FILE__) . "/php/simple_html_dom.php");

	global $bdd;
    global $_TABLES;

    if(!is_null($bdd) && !is_null($_TABLES)) {
        $website = new Website($bdd, $_TABLES);
        $websites = $website->getWebsites();

        if(!is_null($websites)) {

        	foreach ($websites as $key_website => $value_website) {
        		$category = new Category($bdd, $_TABLES);
        		$categories = $category->getCategories($value_website->id);

        		$url = $value_website->url;
        		$file = $value_website->file;

        		// Try to load json config
        		$config = null;
		        $json = file_get_contents($file); 

		        if ($json !== false) { // if Valid Config

		            $config = json_decode($json);
		            
		        }
		        else { // Invalid Config
		            
		            echo "Website File Not Found";
		        }

        		if(!is_null($categories)) {

        			foreach ($categories as $key_category => $value_category) {
		        		$article = new Article($bdd, $_TABLES);

		        		if($value_category->use_url) {
		        			$url .= $value_category->url;
		        		}

		        		$html = file_get_html($url);

		        		if(!is_null($html)) {

		        			$temp['url'] = getElement($html->find($config->container)->find($config->item->container)->find($config->item->url->html), $config->item->url->element);
		        			$temp['title'] = getElement($html->find($config->container)->find($config->item->container)->find($config->item->title->html), $config->item->title->element);
		        			$temp['width_image'] = getElement($html->find($config->container)->find($config->item->container)->find($config->item->width_image->html), $config->item->width_image->element);
		        			$temp['height_image'] = getElement($html->find($config->container)->find($config->item->container)->find($config->item->height_image->html), $config->item->height_image->element);
		        			$temp['image'] = getElement($html->find($config->container)->find($config->item->container)->find($config->item->image->html), $config->item->image->element);
		        			$temp['alt_image'] = getElement($html->find($config->container)->find($config->item->container)->find($config->item->alt_image->html), $config->item->alt_image->element);
		        			$temp['description'] = getElement($html->find($config->container)->find($config->item->container)->find($config->item->description->html), $config->item->description->element);
		        			$temp['date_publication'] = getElement($html->find($config->container)->find($config->item->container)->find($config->item->date_publication->html), $config->item->date_publication->element);
		        			$temp['author'] = getElement($html->find($config->container)->find($config->item->container)->find($config->item->author->html), $config->item->author->element);

		        			$data = json_encode($temps);

		        			$article->setArticle($data);

		        			die('Scrap one article');
		        		}
		        	}
        		}
        		else {
		            echo "Categories Not Found For " . $url;
		        }
        	}
        }
        else {
            echo "Websites Not Found";
        }
    }
    else {
        echo("BDD ERROR : " . json_encode($bdd));
        echo("TABLES ERROR : " . json_encode($_TABLES));
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
?>