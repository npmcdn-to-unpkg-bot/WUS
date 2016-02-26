<?php

	require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/core/system/ajax.php');
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.website_category.php';
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.category.php';
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.website.php';

    /* TEST DE LA VARIABLE ACTION PASSER EN AJAX 
	POUR DETERMINER QUELLE FONCTION EST APPELER */
	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];

	    switch($action) {

	        case 'getAllWebsites' :
	        {
	        	echo getAllWebsites();
	        	break;
	        }

	        case 'getAllCategories' :
	        {
	        	echo getAllCategories();
	        	break;
	        }

	        case 'getAllWebsiteCategoriesDT' : 
	        {
	          	echo getAllWebsiteCategoriesDT();
	        	break; 
	        }

	        case 'deleteWebsiteCategory' : 
	        {
	          	$id = $_POST['id'];

	          	echo deleteWebsiteCategory($id);
	        	break; 
	        }

	        case 'editWebsiteCategory' : 
	        {
	          	$id = $_POST['id'];
	          	$category_id = $_POST['category_id'];
	          	$website_id = $_POST['website_id'];
				$category = $_POST['category'];
				$url = $_POST['url'];
				$use_url = $_POST['use_url'];
				$url_pagination = $_POST['url_pagination'];
				$use_pagination = $_POST['use_pagination'];

	          	echo editWebsiteCategory($id, $category_id, $website_id, $category, $url, $use_url, $url_pagination, $use_pagination);
	        	break; 
	        }

	        case 'createWebsiteCategory' : 
	        {
	          	$category_id = $_POST['category_id'];
	          	$website_id = $_POST['website_id'];
				$category = $_POST['category'];
				$url = $_POST['url'];
				$use_url = $_POST['use_url'];
				$url_pagination = $_POST['url_pagination'];
				$use_pagination = $_POST['use_pagination'];

	          	echo createWebsiteCategory($category_id, $website_id, $category, $url, $use_url, $url_pagination, $use_pagination);
	        	break; 
	        }
	    }
	}

	function getAllWebsites()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '';

		    $objWebsite = new Website($bdd, $_TABLES);
		    $items = $objWebsite->getAllWebsites();

			if($items) {

				foreach ($items as $key => $item) {
    				$content .= '<option value="' . $item->id . '" >' . $item->website . '</option>';
				}
			}

			return $content;

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function getAllCategories()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '';

		    $objCategory = new Category($bdd, $_TABLES);
		    $items = $objCategory->getAllCategories();

			if($items) {

				foreach ($items as $key => $item) {
    				$content .= '<option value="' . $item->id . '" >' . $item->category . '</option>';
				}
			}

			return $content;

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function getAllWebsiteCategoriesDT()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '<thead>';
		    $content .= '<tr>';
		    $content .= '<th>Id</th>';
		    $content .= '<th>Category</th>';
		    $content .= '<th>Website</th>';
		    $content .= '<th>Website Category</th>';
		    $content .= '<th>Url</th>';
		    $content .= '<th>Use Url</th>';
		    $content .= '<th>Url Pagination</th>';
		    $content .= '<th>Use Pagination</th>';
		    $content .= '<th>Action</th>';
		    $content .= '</tr>';
		    $content .= '</thead>';
		    $content .= '<tbody>';

		    $objWebsiteCategory = new WebsiteCategory($bdd, $_TABLES);
		    $items = $objWebsiteCategory->getAllWebsiteCategories();

			if($items) {

				foreach ($items as $key => $item) {
					
					$content .= '<tr website_category_id=' . $item->id . '>';
				    $content .= '<td>' . $item->id . '</td>';
				    $content .= '<td><select class="select_dt select_dt_category_id">';

				    $objCategory = new Category($bdd, $_TABLES);
		    		$categories_items = $objCategory->getAllCategories();

		    		if($categories_items) {

		    			foreach ($categories_items as $key_c => $category_item) {

		    				$temp_content = '';
		    				$temp_content .= '<option value="' . $category_item->id . '" ';

		    				if($category_item->id == $item->category_id) {
		    					$temp_content .= 'selected>'; 
		    				} else {
		    					$temp_content .= '>';
		    				}

		    				$temp_content .= $category_item->category . '</option>';

		    				$content .= $temp_content;
		    			}

		    		}

				    $content .= '</select></td>';
				    $content .= '<td><select class="select_dt select_dt_website_id">';

				    $objWebsite = new Website($bdd, $_TABLES);
		    		$websites_items = $objWebsite->getAllWebsites();

		    		if($websites_items) {

		    			foreach ($websites_items as $key_w => $website_item) {

		    				$temp_content = '';
		    				$temp_content .= '<option value="' . $website_item->id . '" ';

		    				if($website_item->id == $item->website_id) {
		    					$temp_content .= 'selected>'; 
		    				} else {
		    					$temp_content .= '>';
		    				}

		    				$temp_content .= $website_item->website . '</option>';

		    				$content .= $temp_content;
		    			}

		    		}

				    $content .= '</select></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_website_category" value="' . $item->category . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_url" value="' . $item->url . '" /></td>';
				    $content .= '<td><input type="checkbox" class="input_dt input_dt_use_url" value="' . $item->use_url . '"></input></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_url_pagination" value="' . $item->url_pagination . '" /></td>';
				    $content .= '<td><input type="checkbox" class="input_dt input_dt_use_pagination" value="' . $item->use_pagination . '"></input></td>';
				    $content .= "<td><input type='button' class='edit edit_website_category_dt' value='Save' />
				    <input type='button' class='delete delete_website_category_dt' value='Supprimer' /></td>";
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

	function deleteWebsiteCategory($id)
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objWebsiteCategory = new WebsiteCategory($bdd, $_TABLES);
		    $objWebsiteCategory->deleteWebsiteCategory($id);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function editWebsiteCategory($id, $category_id, $website_id, $category, $url, $use_url, $url_pagination, $use_pagination) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objWebsiteCategory = new WebsiteCategory($bdd, $_TABLES);
		    $objWebsiteCategory->editWebsiteCategory($id, $category_id, $website_id, $category, $url, $use_url, $url_pagination, $use_pagination);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }

	}

	function createWebsiteCategory($category_id, $website_id, $category, $url, $use_url, $url_pagination, $use_pagination) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objWebsiteCategory = new WebsiteCategory($bdd, $_TABLES);
		   	$objWebsiteCategory->createWebsiteCategory($category_id, $website_id, $category, $url, $use_url, $url_pagination, $use_pagination);
		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

?>