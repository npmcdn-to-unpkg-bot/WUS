<?php

	require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/core/system/ajax.php');
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.website_subscription.php';
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.user.php';
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.website.php';

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

	        case 'getAllWebsites' :
	        {
	        	echo getAllWebsites();
	        	break;
	        }

	        case 'getAllWebsiteSubscriptionsDT' : 
	        {
	          	echo getAllWebsiteSubscriptionsDT();
	        	break; 
	        }

	        case 'deleteWebsiteSubscription' : 
	        {
	          	$id = $_POST['id'];

	          	echo deleteWebsiteSubscription($id);
	        	break; 
	        }

	        case 'editWebsiteSubscription' : 
	        {
	          	$id = $_POST['id'];
	          	$user_id = $_POST['user_id'];
	          	$website_id = $_POST['website_id'];

	          	echo editWebsiteSubscription($id, $user_id, $website_id);
	        	break; 
	        }

	        case 'createWebsiteSubscription' : 
	        {
	          	$user_id = $_POST['user_id'];
	          	$website_id = $_POST['website_id'];

	          	echo createWebsiteSubscription($user_id, $website_id);
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

	function getAllWebsites()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '';

		    $objWebsite = new Website($bdd, $_TABLES);
		    $websites = $objWebsite->getAllWebsites();

			if($websites) {

				foreach ($websites as $key => $website) {
    				$content .= '<option value="' . $website->id . '" >' . $website->website . '</option>';
				}
			}

			return $content;

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function getAllWebsiteSubscriptionsDT()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$content = '<thead>';
		    $content .= '<tr>';
		    $content .= '<th>Id</th>';
		    $content .= '<th>User</th>';
		    $content .= '<th>Website</th>';
		    $content .= '<th>Action</th>';
		    $content .= '</tr>';
		    $content .= '</thead>';
		    $content .= '<tbody>';

		    $objWebsiteSubscription = new WebsiteSubscription($bdd, $_TABLES);
		    $website_subscriptions = $objWebsiteSubscription->getAllWebsiteSubscriptions();

			if($website_subscriptions) {

				foreach ($website_subscriptions as $key => $website_subscription) {
					
					$content .= '<tr website_subscription_id=' . $website_subscription->id . '>';
				    $content .= '<td>' . $website_subscription->id . '</td>';
				    
				    $content .= '<td><select class="select_dt select_dt_user_id">';

				    $objUser = new User($bdd, $_TABLES);
		    		$users_items = $objUser->getAllUsers();

		    		if($users_items) {

		    			foreach ($users_items as $key_u => $user_item) {

		    				$temp_content = '';
		    				$temp_content .= '<option value="' . $user_item->id . '" ';

		    				if($user_item->id == $website_subscription->user_id) {
		    					$temp_content .= 'selected>'; 
		    				} else {
		    					$temp_content .= '>';
		    				}

		    				$temp_content .= $user_item->name . '</option>';

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

		    				if($website_item->id == $website_subscription->website_id) {
		    					$temp_content .= 'selected>'; 
		    				} else {
		    					$temp_content .= '>';
		    				}

		    				$temp_content .= $website_item->website . '</option>';

		    				$content .= $temp_content;
		    			}

		    		}

				    $content .= '</select></td>';

				    $content .= "<td><input type='button' class='edit edit_website_subscription_dt' value='Save' />
				    <input type='button' class='delete delete_website_subscription_dt' value='Supprimer' /></td>";
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

	function deleteWebsiteSubscription($id)
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objWebsiteSubscription = new WebsiteSubscription($bdd, $_TABLES);
		    $objWebsiteSubscription->deleteWebsiteSubscription($id);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function editWebsiteSubscription($id, $user_id, $website_id) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objWebsiteSubscription = new WebsiteSubscription($bdd, $_TABLES);
		    $objWebsiteSubscription->editWebsiteSubscription($id, $user_id, $website_id);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }

	}

	function createWebsiteSubscription($user_id, $website_id) {

		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objWebsiteSubscription = new WebsiteSubscription($bdd, $_TABLES);
		    $objWebsiteSubscription->createWebsiteSubscription($user_id, $website_id);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

?>