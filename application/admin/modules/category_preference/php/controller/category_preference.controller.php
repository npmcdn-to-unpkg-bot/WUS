<?php

	require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/core/system/ajax.php');
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.category_preference.php';
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.user.php';
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.category.php';

    /* TEST DE LA VARIABLE ACTION PASSER EN AJAX 
	POUR DETERMINER QUELLE FONCTION EST APPELER */
	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];

	    switch($action) {

	    	case 'getAllUsers' :
	        {
	        	echo getAllUsers();
	        	break;
	        }

	        case 'getAllCategories' :
	        {
	        	echo getAllCategories();
	        	break;
	        }

	        case 'getAllCategoryPreferencesDT' : 
	        {
	          	echo getAllCategoryPreferencesDT();
	        	break; 
	        }

	        case 'deleteCategoryPreference' : 
	        {
	          	$id = $_POST['id'];

	          	echo deleteCategoryPreference($id);
	        	break; 
	        }

	        case 'editCategoryPreference' : 
	        {
	          	$id = $_POST['id'];
	          	$user_id = $_POST['user_id'];
	          	$category_id = $_POST['category_id'];

	          	echo editCategoryPreference($id, $user_id, $category_id);
	        	break; 
	        }

	        case 'createCategoryPreference' : 
	        {
	          	$user_id = $_POST['user_id'];
	          	$category_id = $_POST['category_id'];

	          	echo createCategoryPreference($user_id, $category_id);
	        	break; 
	        }
	    }
	}

	function getAllUsers()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '';

		    $objUser = new User($bdd, $_TABLES);
		    $users = $objUser->getAllUsers();

			if($users) {

				foreach ($users as $key => $user) {
    				$content .= '<option value="' . $user->id . '" >' . $user->name . '</option>';
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

	function getAllCategoryPreferencesDT()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '<thead>';
		    $content .= '<tr>';
		    $content .= '<th>Id</th>';
		    $content .= '<th>User</th>';
		    $content .= '<th>Category</th>';
		    $content .= '<th>Action</th>';
		    $content .= '</tr>';
		    $content .= '</thead>';
		    $content .= '<tbody>';

		    $objCategoryPreference = new CategoryPreference($bdd, $_TABLES);
		    $category_preferences = $objCategoryPreference->getAllCategoryPreferences();

			if($category_preferences) {

				foreach ($category_preferences as $key => $category_preference) {
					
					$content .= '<tr category_preference_id=' . $category_preference->id . '>';
				    $content .= '<td>' . $category_preference->id . '</td>';
					
				    $content .= '<td><select class="select_dt select_dt_user_id">';

				    $objUser = new User($bdd, $_TABLES);
		    		$users_items = $objUser->getAllUsers();

		    		if($users_items) {

		    			foreach ($users_items as $key_u => $user_item) {

		    				$temp_content = '';
		    				$temp_content .= '<option value="' . $user_item->id . '" ';

		    				if($user_item->id == $category_preference->user_id) {
		    					$temp_content .= 'selected>'; 
		    				} else {
		    					$temp_content .= '>';
		    				}

		    				$temp_content .= $user_item->name . '</option>';

		    				$content .= $temp_content;
		    			}

		    		}

				    $content .= '</select></td>';

				    $content .= '<td><select class="select_dt select_dt_category_id">';

				    $objCategory = new Category($bdd, $_TABLES);
		    		$categories_items = $objCategory->getAllCategories();

		    		if($categories_items) {

		    			foreach ($categories_items as $key_u => $category_item) {

		    				$temp_content = '';
		    				$temp_content .= '<option value="' . $category_item->id . '" ';

		    				if($category_item->id == $category_preference->category_id) {
		    					$temp_content .= 'selected>'; 
		    				} else {
		    					$temp_content .= '>';
		    				}

		    				$temp_content .= $category_item->category . '</option>';

		    				$content .= $temp_content;
		    			}

		    		}

				    $content .= '</select></td>';

				    $content .= "<td><input type='button' class='edit edit_category_preference_dt' value='Save' />
				    <input type='button' class='delete delete_category_preference_dt' value='Supprimer' /></td>";
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

	function deleteCategoryPreference($id)
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objCategoryPreference = new CategoryPreference($bdd, $_TABLES);
		    $objCategoryPreference->deleteCategoryPreference($id);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function editCategoryPreference($id, $user_id, $category_id) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objCategoryPreference = new CategoryPreference($bdd, $_TABLES);
		    $objCategoryPreference->editCategoryPreference($id, $user_id, $category_id);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }

	}

	function createCategoryPreference($user_id, $category_id) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objCategoryPreference = new CategoryPreference($bdd, $_TABLES);
		    $objCategoryPreference->createCategoryPreference($user_id, $category_id);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

?>