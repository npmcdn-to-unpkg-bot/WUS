<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/core/system/ajax.php');
require_once(dirname(dirname(__FILE__)) . "/php/class.login.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch($action) {
        case 'login' : {
            $username = $_POST['username'];
            $password = $_POST['password'];

			echo login($username, $password);
			break;
        }

        case 'logout' : {
            echo logout();
            break;
        }
    }
}

function login($username, $password) {
    global $bdd;
    global $_TABLES;

    if(!is_null($bdd) && !is_null($_TABLES)) {
        $objLogin = new Login($bdd, $_TABLES);
        $login = $objLogin->getLogin($username, $password);

        if(!is_null($login)) {

            $_SESSION['user_auth'] = '1';
            $_SESSION['user_id'] = $login->id;

            return true;
        }
        else {

            $_SESSION['user_auth'] = '0';

            return false;
        }
    }
    else {
        error_log("BDD ERROR : " . json_encode($bdd));
        error_log("TABLES ERROR : " . json_encode($_TABLES));
    }
}

function logout() {
    unset($_SESSION['user_auth']);
    unset($_SESSION['user_id']);

    return true;
}

?>