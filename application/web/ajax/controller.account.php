<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(dirname(dirname(dirname(__FILE__))) . '/core/system/ajax.php');
require_once(dirname(dirname(dirname(__FILE__))) . "/common/php/class/class.user.php");
require_once(dirname(dirname(dirname(__FILE__))) . "/common/php/class/class.user_newsletter.php");

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch($action) {
        case 'updateAccount' : {

            // Acquisition de toutes les variables
            (isset($_POST['first-name']) && !empty($_POST['first-name'])) ? $first_name = $_POST['first-name'] : $first_name = null;
            (isset($_POST['last-name']) && !empty($_POST['last-name'])) ? $last_name = $_POST['last-name'] : $last_name = null;
            (isset($_POST['birthday']) && !empty($_POST['birthday'])) ? $birthday = $_POST['birthday'] : $birthday = null;
            (isset($_POST['sex']) && !empty($_POST['sex'])) ? $sex = $_POST['sex'] : $sex = null;
            (isset($_POST['email']) && !empty($_POST['email'])) ? $email = $_POST['email'] : $email = null;
            (isset($_POST['password']) && !empty($_POST['password'])) ? $password = $_POST['password'] : $password = null;
            (isset($_POST['newsletter']) && !empty($_POST['newsletter'])) ? $newsletter = $_POST['newsletter'] : $newsletter = null;

            echo updateAccount($first_name, $last_name, $birthday, $sex, $email, $password, $newsletter);
            break;
        }
    }
}

function updateAccount($first_name, $last_name, $birthday, $sex, $email, $password, $newsletter) {

    global $bdd;
    global $_TABLES;
    global $config;

    if(isset($_SESSION['user_id'])) {

        // Création de l'objet User
        $objUser = new User($bdd, $_TABLES);

        // Sauvegarde temporaire des anciennes données utilisateurs
        $user = $objUser->getData($_SESSION['user_id']);
        
        // Mise en forme des données
        $birthday_temp = explode("/", $birthday);
        $birthday = $birthday_temp[2] . '-' . $birthday_temp[1] . '-' . $birthday_temp[0];

        // Mise à jour des données du compte
        $objUser->updateAccount($_SESSION['user_id'], $email, $password, $first_name, $last_name, $birthday, $sex);

        // Ajout ou suppression de l'email de la personne dans la liste de la newsletter
        $objUserNewsletter = new UserNewsletter($bdd, $_TABLES, $config);

        if($newsletter) {
            $objUserNewsletter->createUserNewsletter($email);
        } else {

            $email_delete = $email;

            // Verification que l'email n'a pas été modifier avant
            if($user && !is_null($user)) {
                if($email != $user->email) {
                    $email_delete = $user->email;
                }
            }

            $user_newsletter = $objUserNewsletter->getExist($email_delete);

            if($user_newsletter && !is_null($user_newsletter)) {
                $objUserNewsletter->deleteUserNewsletter($user_newsletter->id, $email_delete);
            }
        }

        // Retour 0
        return 0;
    }
    else {
        // Session expire
        return 1;
    }
}

?>