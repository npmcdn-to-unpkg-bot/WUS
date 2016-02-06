<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/core/system/ajax.php');
require_once(dirname(dirname(dirname(__FILE__))) . "/common/php/class/class.user_newsletter.php");

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch($action) {
        case 'createNewsletter' : {

            // Acquisition de toutes les variables
            (isset($_POST['email']) && !empty($_POST['email'])) ? $email = $_POST['email'] : $email = null;

            echo createNewsletter($email);
            break;
        }
    }
}

function createNewsletter($email) {

    global $bdd;
    global $_TABLES;

    // Ajout ou suppression de l'email de la personne dans la liste de la newsletter
    $objUserNewsletter = new UserNewsletter($bdd, $_TABLES);
    $objUserNewsletter->createUserNewsletter($email);

    // Retour 0
    return 0;
}

?>