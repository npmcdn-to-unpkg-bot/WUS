<?php

	require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/core/system/ajax.php');
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.user.php';

    /* TEST DE LA VARIABLE ACTION PASSER EN AJAX 
	POUR DETERMINER QUELLE FONCTION EST APPELER */
	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];

	    switch($action) {

	        case 'getAllUsersDT' : 
	        {
	          	echo getAllUsersDT();
	        	break; 
	        }

	        case 'deleteUser' : 
	        {
	          	$id = $_POST['id'];

	          	echo deleteUser($id);
	        	break; 
	        }

	        case 'editUser' : 
	        {
	          	$id = $_POST['id'];
	          	$name = $_POST['name'];
	          	$login = $_POST['login'];
	          	$pass = $_POST['pass'];
	          	$valid = $_POST['valid'];

	          	echo editUser($id, $name, $login, $pass, $valid);
	        	break; 
	        }

	        case 'createUser' : 
	        {
	          	$name = $_POST['name'];
	          	$login = $_POST['login'];
	          	$pass = $_POST['pass'];
	          	$valid = $_POST['valid'];

	          	echo createUser($name, $login, $pass, $valid);
	        	break; 
	        }
	    }
	}

	function getAllUsersDT()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '<thead>';
		    $content .= '<tr>';
		    $content .= '<th>Id</th>';
		    $content .= '<th>Name</th>';
		    $content .= '<th>Login</th>';
		    $content .= '<th>Pass</th>';
		    $content .= '<th>Valid</th>';
		    $content .= '<th>Action</th>';
		    $content .= '</tr>';
		    $content .= '</thead>';
		    $content .= '<tbody>';

		    $objUser = new User($bdd, $_TABLES);
		    $users = $objUser->getAllUsers();

			if($users) {

				foreach ($users as $key => $user) {
					
					$content .= '<tr user_id=' . $user->id . '>';
				    $content .= '<td>' . $user->id . '</td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_name" value="' . $user->name . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_login" value="' . $user->login . '" /></td>';
				    $content .= '<td><input type="text" class="input_dt input_dt_pass" value="" /></td>';
				    $content .= '<td><input type="checkbox" class="input_dt input_dt_valid" value="' . $user->valid . '" /></td>';
				    $content .= "<td><input type='button' class='edit edit_user_dt' value='Save' />
				    <input type='button' class='delete delete_user_dt' value='Supprimer' /></td>";
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

	function deleteUser($id)
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objUser = new User($bdd, $_TABLES);
		    $objUser->deleteUser($id);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function editUser($id, $name, $login, $pass, $valid) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objUser = new User($bdd, $_TABLES);
		    $objUser->editUser($id, $name, $login, $pass, $valid);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }

	}

	function createUser($name, $login, $pass, $valid) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objUser = new User($bdd, $_TABLES);
		    $objUser->createUser($name, $login, $pass, $valid);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

?>