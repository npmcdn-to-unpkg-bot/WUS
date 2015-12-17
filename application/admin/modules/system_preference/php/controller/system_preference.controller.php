<?php

	require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/core/system/ajax.php');
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/common/php/class/class.system_preference.php';

    /* TEST DE LA VARIABLE ACTION PASSER EN AJAX 
	POUR DETERMINER QUELLE FONCTION EST APPELER */
	if(isset($_POST['action']) && !empty($_POST['action'])) {
	    $action = $_POST['action'];

	    switch($action) {

	        case 'getSystemPreference' : 
	        {
	          	echo getSystemPreference();
	        	break; 
	        }

	        case 'editSystemPreference' : 
	        {
	          	$url_facebook = $_POST['url_facebook'];
	          	$url_instagram = $_POST['url_instagram'];
	          	$url_twitter = $_POST['url_twitter'];
	          	$url_rss = $_POST['url_rss'];
	          	$url_sitemap = $_POST['url_sitemap'];
	          	$counter_carrousel = $_POST['counter_carrousel'];

	          	echo editSystemPreference($url_facebook, $url_instagram, $url_twitter, $url_rss, $url_sitemap, $counter_carrousel);
	        	break; 
	        }
	    }
	}

	function getSystemPreference()
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objSystemPreference = new SystemPreference($bdd, $_TABLES);
			$system_preference = $objSystemPreference->getSystemPreference();

			if($system_preference) {
				return json_encode($system_preference);
			}
			else {
				return null;
			}

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

	function editSystemPreference($url_facebook, $url_instagram, $url_twitter, $url_rss, $url_sitemap, $counter_carrousel)
	{
		global $bdd, $_TABLES;

		if(!is_null($bdd) && !is_null($_TABLES)) {

			$objSystemPreference = new SystemPreference($bdd, $_TABLES);
		    $objSystemPreference->editSystemPreference($url_facebook, $url_instagram, $url_twitter, $url_rss, $url_sitemap, $counter_carrousel);

		}
	    else {
	        error_log("BDD ERROR : " . json_encode($bdd));
	        error_log("TABLES ERROR : " . json_encode($_TABLES));
	    }
	}

?>