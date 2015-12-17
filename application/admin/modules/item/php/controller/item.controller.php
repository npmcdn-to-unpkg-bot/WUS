<?php

	require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/core/system/ajax.php');
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.item.php';
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.type_item.php';
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.website_category.php';

    /* TEST DE LA VARIABLE ACTION PASSER EN AJAX 
	POUR DETERMINER QUELLE FONCTION EST APPELER */
	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];

	    switch($action) {

	        case 'getAllTypeItems' :
	        {
	        	echo getAllTypeItems();
	        	break;
	        }

	        case 'getAllWebsiteCategories' :
	        {
	        	echo getAllWebsiteCategories();
	        	break;
	        }

	        case 'getAllItemsDT' : 
	        {
	          	echo getAllItemsDT();
	        	break; 
	        }

	        case 'deleteItem' : 
	        {
	          	$id = $_POST['id'];

	          	echo deleteItem($id);
	        	break; 
	        }

	        case 'editItem' : 
	        {
	          	$id = $_POST['id'];
	          	$type_item_id = $_POST['type_item_id'];
	          	$website_category_id = $_POST['website_category_id'];
	          	$guid = $_POST['guid'];
	          	$url = $_POST['url'];
	          	$title = $_POST['title'];
	          	$width_image = $_POST['width_image'];
	          	$height_image = $_POST['height_image'];
	          	$image = $_POST['image'];
	          	$alt_image = $_POST['alt_image'];
	          	$description = $_POST['description'];
	          	$date_publication = $_POST['date_publication'];
	          	$author = $_POST['author'];

	          	echo editItem($id, $type_item_id, $website_category_id, $guid, $url, $title, $width_image, $height_image, $image, $alt_image, $description, $date_publication, $author);
	        	break; 
	        }

	        case 'createItem' : 
	        {
	          	$type_item_id = $_POST['type_item_id'];
	          	$website_category_id = $_POST['website_category_id'];
	          	$url = $_POST['url'];
	          	$title = $_POST['title'];
	          	$width_image = $_POST['width_image'];
	          	$height_image = $_POST['height_image'];
	          	$image = $_POST['image'];
	          	$alt_image = $_POST['alt_image'];
	          	$description = $_POST['description'];
	          	$date_publication = $_POST['date_publication'];
	          	$author = $_POST['author'];

	          	echo createItem($type_item_id, $website_category_id, $url, $title, $width_image, $height_image, $image, $alt_image, $description, $date_publication, $author);
	        	break; 
	        }
	    }
	}

	function getAllTypeItems()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '';

		    $objTypeItem = new TypeItem($bdd, $_TABLES);
		    $items = $objTypeItem->getAllTypeItems();

			if($items) {

				foreach ($items as $key => $item) {
    				$content .= '<option value="' . $item->id . '" >' . $item->type . '</option>';
				}
			}

			return $content;

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function getAllWebsiteCategories()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '';

		    $objWebsiteCategory = new WebsiteCategory($bdd, $_TABLES);
		    $items = $objWebsiteCategory->getAllWebsiteCategories();

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

	function getAllItemsDT()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '<thead>';
		    $content .= '<tr>';
		    $content .= '<th>Id</th>';
		    $content .= '<th>Type Item</th>';
		    $content .= '<th>Website Category</th>';
		    $content .= '<th>Guid</th>';
		    $content .= '<th>Url</th>';
		    $content .= '<th>Title</th>';
		    $content .= '<th>Width Image</th>';
		    $content .= '<th>Height Image</th>';
		    $content .= '<th>Image</th>';
		    $content .= '<th>Alt Image</th>';
		    $content .= '<th>Description</th>';
		    $content .= '<th>Date Publication</th>';
		    $content .= '<th>Author</th>';
		    $content .= '<th>Action</th>';
		    $content .= '</tr>';
		    $content .= '</thead>';
		    $content .= '<tbody>';

		    $objItem = new Item($bdd, $_TABLES);
		    $items = $objItem->getAllItems();

			if($items) {

				foreach ($items as $key => $item) {
					
					$content .= '<tr item_id=' . $item->id . '>';
				    $content .= '<td>' . $item->id . '</td>';
				    
				    $content .= '<td><select class="select_dt select_dt_type_item_id">';

				    $objTypeItem = new TypeItem($bdd, $_TABLES);
		    		$types_items = $objTypeItem->getAllTypeItems();

		    		if($types_items) {

		    			foreach ($types_items as $key_ti => $type_item) {

		    				$temp_content = '';
		    				$temp_content .= '<option value="' . $type_item->id . '" ';

		    				if($type_item->id == $item->type_item_id) {
		    					$temp_content .= 'selected>'; 
		    				} else {
		    					$temp_content .= '>';
		    				}

		    				$temp_content .= $type_item->type . '</option>';

		    				$content .= $temp_content;
		    			}

		    		}

				    $content .= '</select></td>';

				    $content .= '<td><select class="select_dt select_dt_website_category_id">';

				    $objWebsiteCategory = new WebsiteCategory($bdd, $_TABLES);
		    		$websites_categories = $objWebsiteCategory->getAllWebsiteCategories();

		    		if($websites_categories) {

		    			foreach ($websites_categories as $key_wc => $website_category) {

		    				$temp_content = '';
		    				$temp_content .= '<option value="' . $website_category->id . '" ';

		    				if($website_category->id == $item->website_category_id) {
		    					$temp_content .= 'selected>'; 
		    				} else {
		    					$temp_content .= '>';
		    				}

		    				$temp_content .= $website_category->category . '</option>';

		    				$content .= $temp_content;
		    			}

		    		}

				    $content .= '</select></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_guid" value="' . $item->guid . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_url" value="' . $item->url . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_title" value="' . $item->title . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_width_image" value="' . $item->width_image . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_height_image" value="' . $item->height_image . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_image" value="' . $item->image . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_alt_image" value="' . $item->alt_image . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_description" value="' . $item->description . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_date_publication" value="' . $item->date_publication . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_author" value="' . $item->author . '" /></td>';
				    $content .= "<td><input type='button' class='edit edit_item_dt' value='Save' />
				    <input type='button' class='delete delete_item_dt' value='Supprimer' /></td>";
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

	function deleteItem($id)
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objItem = new Item($bdd, $_TABLES);
		    $objItem->deleteItem($id);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function editItem($id, $type_item_id, $website_category_id, $guid, $url, $title, $width_image, $height_image, $image, $alt_image, $description, $date_publication, $author) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objItem = new Item($bdd, $_TABLES);
		    $objItem->editItem($id, $type_item_id, $website_category_id, $guid, $url, $title, $width_image, $height_image, $image, $alt_image, $description, $date_publication, $author);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }

	}

	function createItem($type_item_id, $website_category_id, $url, $title, $width_image, $height_image, $image, $alt_image, $description, $date_publication, $author) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$guid = substr(md5(microtime(TRUE) * 100000), 0, 5);

			$objItem = new Item($bdd, $_TABLES);
		    $objItem->createItem($type_item_id, $website_category_id, $guid, $url, $title, $width_image, $height_image, $image, $alt_image, $description, $date_publication, $author);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

?>