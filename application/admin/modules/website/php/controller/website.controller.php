<?php

	require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/core/system/ajax.php');
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.website.php';

    /* TEST DE LA VARIABLE ACTION PASSER EN AJAX 
	POUR DETERMINER QUELLE FONCTION EST APPELER */
	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];

	    switch($action) {

	        case 'getAllWebsitesDT' : 
	        {
	          	echo getAllWebsitesDT();
	        	break; 
	        }

	        case 'deleteWebsite' : 
	        {
	          	$id = $_POST['id'];

	          	echo deleteWebsite($id);
	        	break; 
	        }

	        case 'editWebsite' : 
	        {
	          	$id = $_POST['id'];
	          	$website = $_POST['website'];
				$url = $_POST['url'];
				$logo = $_POST['logo'];
				$file = $_POST['file'];
				$scrap = $_POST['scrap'];

	          	echo editWebsite($id, $website, $url, $logo, $file, $scrap);
	        	break; 
	        }

	        case 'createWebsite' : 
	        {
	          	$website = $_POST['website'];
				$url = $_POST['url'];
				$logo = $_POST['logo'];
				$scrap = $_POST['scrap'];
				$container = $_POST['container'];
				$item_container = $_POST['item-container'];
				$item_url_html = $_POST['item-url-html'];
				$item_url_element = $_POST['item-url-element'];
				$item_title_html = $_POST['item-title-html'];
				$item_title_element = $_POST['item-title-element'];
				$item_width_image_html = $_POST['item-width_image-html'];
				$item_width_image_element = $_POST['item-width_image-element'];
				$item_height_image_html = $_POST['item-height_image-html'];
				$item_height_image_element = $_POST['item-height_image-element'];
				$item_image_html = $_POST['item-image-html'];
				$item_image_element = $_POST['item-image-element'];
				$item_alt_image_html = $_POST['item-alt_image-html'];
				$item_alt_image_element = $_POST['item-alt_image-element'];
				$item_description_html = $_POST['item-description-html'];
				$item_description_element = $_POST['item-description-element'];
				$item_date_publication_html = $_POST['item-date_publication-html'];
				$item_date_publication_element = $_POST['item-date_publication-element'];
				$item_author_html = $_POST['item-author-html'];
				$item_author_element = $_POST['item-author-element'];
				$item_inner_date_publication_html = $_POST['item-inner-date-publication-html'];
				$item_inner_date_publication_element = $_POST['item-inner-date-publication-element'];
				$item_inner_date_publication_format = $_POST['item-inner-date-publication-format'];
				$item_inner_date_publication_function_type = $_POST['item-inner-date-publication-function-type'];
				$item_inner_date_publication_function_separator = $_POST['item-inner-date-publication-function-separator'];
				$item_inner_date_publication_function_counter = $_POST['item-inner-date-publication-function-counter'];

	          	echo createWebsite($website, $url, $logo, $scrap, 
	          	$container, 
	          	$item_container,
				$item_url_html,
				$item_url_element,
				$item_title_html,
				$item_title_element,
				$item_width_image_html,
				$item_width_image_element,
				$item_height_image_html,
				$item_height_image_element,
				$item_image_html,
				$item_image_element,
				$item_alt_image_html,
				$item_alt_image_element,
				$item_description_html,
				$item_description_element,
				$item_date_publication_html,
				$item_date_publication_element,
				$item_author_html,
				$item_author_element,
				$item_inner_date_publication_html,
				$item_inner_date_publication_element,
				$item_inner_date_publication_format,
				$item_inner_date_publication_function_type,
				$item_inner_date_publication_function_separator,
				$item_inner_date_publication_function_counter);
	        	break; 
	        }
	    }
	}

	function getAllWebsitesDT()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '<thead>';
		    $content .= '<tr>';
		    $content .= '<th>Id</th>';
		    $content .= '<th>Website</th>';
		    $content .= '<th>Url</th>';
		    $content .= '<th>Logo</th>';
		    $content .= '<th>File</th>';
		    $content .= '<th>Scrap</th>';
		    $content .= '<th>Action</th>';
		    $content .= '</tr>';
		    $content .= '</thead>';
		    $content .= '<tbody>';

		    $objWebsite = new Website($bdd, $_TABLES);
		    $items = $objWebsite->getAllWebsites();

			if($items) {

				foreach ($items as $key => $item) {
					
					$content .= '<tr websiteId=' . $item->id . '>';
				    $content .= '<td>' . $item->id . '</td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_website" value="' . $item->website . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_url" value="' . $item->url . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_logo" value="' . $item->logo . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_file" value="' . $item->file . '" /></td>';
				    $content .= '<td><input type="checkbox" class="input_dt input_dt_scrap" value="' . $item->scrap . '"></input></td>';
				    $content .= "<td><input type='button' class='edit edit_website_dt' value='Save' />
				    <input type='button' class='delete delete_website_dt' value='Supprimer' /></td>";
				    $content .= '</tr>';
				}
			}

			$content .= '</tbody>';
			return $content;

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function deleteWebsite($id)
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objWebsite = new Website($bdd, $_TABLES);
		    $objWebsite->deleteWebsite($id);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function editWebsite($id, $website, $url, $logo, $file, $scrap) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objWebsite = new Website($bdd, $_TABLES);
		    $objWebsite->editWebsite($id, $website, $url, $logo, $file, $scrap);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }

	}

	function createWebsite($website, $url, $logo, $scrap, 
				$container, 
				$item_container,
				$item_url_html,
				$item_url_element,
				$item_title_html,
				$item_title_element,
				$item_width_image_html,
				$item_width_image_element,
				$item_height_image_html,
				$item_height_image_element,
				$item_image_html,
				$item_image_element,
				$item_alt_image_html,
				$item_alt_image_element,
				$item_description_html,
				$item_description_element,
				$item_date_publication_html,
				$item_date_publication_element,
				$item_author_html,
				$item_author_element,
				$item_inner_date_publication_html,
				$item_inner_date_publication_element,
				$item_inner_date_publication_format,
				$item_inner_date_publication_function_type,
				$item_inner_date_publication_function_separator,
				$item_inner_date_publication_function_counter) {


		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$jsonConfigDir = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/cron/websites/config/";
			$filename = mb_strtolower(str_replace(' ', '_', $website), 'UTF-8') . ".json";

			$output = $jsonConfigDir . $filename;
			$file = "/application/cron/websites/config/" . $filename;

			$view = new Template(dirname(dirname(dirname(__FILE__))) . '/view/template-json.html');
			$json = $view->getView(array(
                    "container" => $container,
					"item-container" => $item_container,
					"item-url-html" => $item_url_html,
					"item-url-element" => $item_url_element,
					"item-title-html" => $item_title_html,
					"item-title-element" => $item_title_element,
					"item-width_image-html" => $item_width_image_html,
					"item-width_image-element" => $item_width_image_element,
					"item-height_image-html" => $item_height_image_html,
					"item-height_image-element" => $item_height_image_element,
					"item-image-html" => $item_image_html,
					"item-image-element" => $item_image_element,
					"item-alt_image-html" => $item_alt_image_html,
					"item-alt_image-element" => $item_alt_image_element,
					"item-description-html" => $item_description_html,
					"item-description-element" => $item_description_element,
					"item-date_publication-html" => $item_date_publication_html,
					"item-date_publication-element" => $item_date_publication_element,
					"item-author-html" => $item_author_html,
					"item-author-element" => $item_author_element,
					"item_inner-date_publication-html" => $item_inner_date_publication_html,
					"item_inner-date_publication-element" => $item_inner_date_publication_element,
					"item_inner-date_publication-format" => $item_inner_date_publication_format,
					"item_inner-date_publication-function-type" => $item_inner_date_publication_function_type,
					"item_inner-date_publication-function-separator" => $item_inner_date_publication_function_separator,
					"item_inner-date_publication-function-counter" => $item_inner_date_publication_function_counter
                    ));

			$createFile = file_put_contents($output, $json);

			if($createFile != false) {
				$objWebsite = new Website($bdd, $_TABLES);
		    	$objWebsite->createWebsite($website, $url, $logo, $file, $scrap);
			}

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

?>