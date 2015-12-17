<?php

	require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/core/system/ajax.php');
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.type_item.php';

    /* TEST DE LA VARIABLE ACTION PASSER EN AJAX 
	POUR DETERMINER QUELLE FONCTION EST APPELER */
	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];

	    switch($action) {

	        case 'getAllTypeItemsDT' : 
	        {
	          	echo getAllTypeItemsDT();
	        	break; 
	        }

	        case 'deleteTypeItem' : 
	        {
	          	$id = $_POST['id'];

	          	echo deleteTypeItem($id);
	        	break; 
	        }

	        case 'editTypeItem' : 
	        {
	          	$id = $_POST['id'];
	          	$type = $_POST['type'];

	          	echo editTypeItem($id, $type);
	        	break; 
	        }

	        case 'createTypeItem' : 
	        {
	          	$type = $_POST['type'];

	          	echo createTypeItem($type);
	        	break; 
	        }
	    }
	}

	function getAllTypeItemsDT()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '<thead>';
		    $content .= '<tr>';
		    $content .= '<th>Id</th>';
		    $content .= '<th>Type</th>';
		    $content .= '<th>Action</th>';
		    $content .= '</tr>';
		    $content .= '</thead>';
		    $content .= '<tbody>';

		    $objTypeItem = new TypeItem($bdd, $_TABLES);
		    $type_items = $objTypeItem->getAllTypeItems();

			if($type_items) {

				foreach ($type_items as $key => $type_item) {
					
					$content .= '<tr type_item_id=' . $type_item->id . '>';
				    $content .= '<td>' . $type_item->id . '</td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_type" value="' . $type_item->type . '" /></td>';
				    $content .= "<td><input type='button' class='edit edit_type_item_dt' value='Save' />
				    <input type='button' class='delete delete_type_item_dt' value='Supprimer' /></td>";
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

	function deleteTypeItem($id)
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objTypeItem = new TypeItem($bdd, $_TABLES);
		    $objTypeItem->deleteTypeItem($id);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function editTypeItem($id, $type) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objTypeItem = new TypeItem($bdd, $_TABLES);
		    $objTypeItem->editTypeItem($id, $type);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }

	}

	function createTypeItem($type) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objTypeItem = new TypeItem($bdd, $_TABLES);
		    $objTypeItem->createTypeItem($type);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

?>