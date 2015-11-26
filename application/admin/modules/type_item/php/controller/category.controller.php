<?php

	require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/core/system/ajax.php');
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.category.php';

    /* TEST DE LA VARIABLE ACTION PASSER EN AJAX 
	POUR DETERMINER QUELLE FONCTION EST APPELER */
	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];

	    switch($action) {

	        case 'getAllCategoriesDT' : 
	        {
	          	echo getAllCategoriesDT();
	        	break; 
	        }

	        case 'deleteCategory' : 
	        {
	          	$id = $_POST['id'];

	          	echo deleteCategory($id);
	        	break; 
	        }

	        case 'editCategory' : 
	        {
	          	$id = $_POST['id'];
	          	$category = $_POST['category'];

	          	echo editCategory($id, $category);
	        	break; 
	        }

	        case 'createCategory' : 
	        {
	          	$category = $_POST['category'];

	          	echo createCategory($category);
	        	break; 
	        }
	    }
	}

	function getAllCategoriesDT()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '<thead>';
		    $content .= '<tr>';
		    $content .= '<th>Id</th>';
		    $content .= '<th>Category</th>';
		    $content .= '<th>Action</th>';
		    $content .= '</tr>';
		    $content .= '</thead>';
		    $content .= '<tbody>';

		    $objCategory = new Category($bdd, $_TABLES);
		    $items = $objCategory->getAllCategories();

			if($items) {

				foreach ($items as $key => $item) {
					
					$content .= '<tr categoryId=' . $item->id . '>';
				    $content .= '<td>' . $item->id . '</td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_category" value="' . $item->category . '" /></td>';
				    $content .= "<td><input type='button' class='edit edit_category_dt' value='Save' />
				    <input type='button' class='delete delete_category_dt' value='Supprimer' /></td>";
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

	function deleteCategory($id)
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objCategory = new Category($bdd, $_TABLES);
		    $objCategory->deleteCategory($id);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function editCategory($id, $category) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objCategory = new Category($bdd, $_TABLES);
		    $objCategory->editCategory($id, $category);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }

	}

	function createCategory($category) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objCategory = new Category($bdd, $_TABLES);
		    $objCategory->createCategory($category);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

?>