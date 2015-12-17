<?php

	require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/core/system/ajax.php');
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.collaboration.php';

    /* TEST DE LA VARIABLE ACTION PASSER EN AJAX 
	POUR DETERMINER QUELLE FONCTION EST APPELER */
	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];

	    switch($action) {

	        case 'getAllCollaborationsDT' : 
	        {
	          	echo getAllCollaborationsDT();
	        	break; 
	        }

	        case 'deleteCollaboration' : 
	        {
	          	$id = $_POST['id'];

	          	echo deleteCollaboration($id);
	        	break; 
	        }

	        case 'editCollaboration' : 
	        {
	          	$id = $_POST['id'];
	          	$collaboration = $_POST['collaboration'];
	          	$url = $_POST['url'];
	          	$image = $_POST['image'];

	          	echo editCollaboration($id, $collaboration, $url, $image);
	        	break; 
	        }

	        case 'createCollaboration' : 
	        {
	          	$collaboration = $_POST['collaboration'];
	          	$url = $_POST['url'];
	          	$image = $_POST['image'];

	          	echo createCollaboration($collaboration, $url, $image);
	        	break; 
	        }
	    }
	}

	function getAllCollaborationsDT()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '<thead>';
		    $content .= '<tr>';
		    $content .= '<th>Id</th>';
		    $content .= '<th>Collaboration</th>';
		    $content .= '<th>Url</th>';
		    $content .= '<th>Image</th>';
		    $content .= '<th>Action</th>';
		    $content .= '</tr>';
		    $content .= '</thead>';
		    $content .= '<tbody>';

		    $objCollaboration = new Collaboration($bdd, $_TABLES);
		    $items = $objCollaboration->getAllCollaborations();

			if($items) {

				foreach ($items as $key => $item) {
					
					$content .= '<tr collaboration_id=' . $item->id . '>';
				    $content .= '<td>' . $item->id . '</td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_collaboration" value="' . $item->collaboration . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_url" value="' . $item->url . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_image" value="' . $item->image . '" /></td>';
				    $content .= "<td><input type='button' class='edit edit_collaboration_dt' value='Save' />
				    <input type='button' class='delete delete_collaboration_dt' value='Supprimer' /></td>";
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

	function deleteCollaboration($id)
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objCollaboration = new Collaboration($bdd, $_TABLES);
		    $objCollaboration->deleteCollaboration($id);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function editCollaboration($id, $collaboration, $url, $image) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objCollaboration = new Collaboration($bdd, $_TABLES);
		    $objCollaboration->editCollaboration($id, $collaboration, $url, $image);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function createCollaboration($collaboration, $url, $image) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objCollaboration = new Collaboration($bdd, $_TABLES);
		    $objCollaboration->createCollaboration($collaboration, $url, $image);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

?>