<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/core/system/ajax.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function getSystemPreference($columns = '*') {
    global $bdd;
    global $_TABLES;

    if(!is_null($bdd) && !is_null($_TABLES)) {
        
    	try 
		{
			$sql = "SELECT $columns FROM " . $_TABLES['system']['Preference'];
			$req = $bdd->prepare($sql);
			$req->execute();
			$item = $req->fetch(PDO::FETCH_OBJ);
		}
		catch (PDOException $e)
		{
		    error_log($sql);
		    error_log($e->getMessage());
		    die();
		}

		if($item) {

			error_log(json_encode($item));

			return $item;
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

?>