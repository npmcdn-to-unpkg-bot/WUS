<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/core/system/ajax.php');
require_once(dirname(dirname(__FILE__)) . "/php/class.login.php");
require_once(dirname(dirname(dirname(__FILE__))) . "/common/php/class/class.website_subscription.php");
require_once(dirname(dirname(dirname(__FILE__))) . "/common/php/class/class.user.php");
require_once(dirname(dirname(dirname(__FILE__))) . "/common/php/tools/hybridauth/Hybrid/Auth.php");
require_once(dirname(dirname(dirname(__FILE__))) . "/core/mailer/class.mailer.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch($action) {
        case 'loginByProvider' : {
            $provider = $_POST['provider'];

            echo loginByProvider($provider);
            break;
        }

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

        case 'lostPassword' : {
            $email = $_POST['email'];

            echo lostPassword($email);
            break;
        }

        case 'checkSessionAuth' : {

            echo checkSessionAuth();
            break;
        }
    }
}

function checkSessionAuth() {
    if($_SESSION['user_auth'] === '1')
    {
        return true;
    } else {
        return false;
    }
}

function loginByProvider($provider) {

    global $bdd;
    global $_TABLES;

    $config = dirname(dirname(dirname(__FILE__))) . '/common/php/tools/hybridauth/config.php';

    try
    {
        // initialize Hybrid_Auth with a given file
        $hybridauth = new Hybrid_Auth($config);
 
        // try to authenticate with the selected provider
        $adapter = $hybridauth->authenticate($provider);
 
        // then grab the user profile 
        $user_profile = $adapter->getUserProfile();

        if($user_profile && !is_null($user_profile)) {

            error_log(json_encode($user_profile));

            $objUser = new User($bdd, $_TABLES); 
            $userProvider = $objUser->getExistByProvider($provider, $user_profile->identifier);
            $user = $objUser->getExist($user_profile->email);


            // Cas 1 = Aucun compte
            if(!$user || is_null($user)) {
                $password = md5(microtime(TRUE) * 100000);
                $verification_key = md5(microtime(TRUE) * 100000);
                $verified = true;
                $blocked = false;

                $sex = ($user_profile->gender == "male" ? 1 : 0);

                error_log($user_profile->birthYear . '-' . $user_profile->birthMonth . '-' . $user_profile->birthMonth);

                if(!is_null($user_profile->birthYear) && !is_null($user_profile->birthMonth) && !is_null($user_profile->birthMonth)) {
                    $birthday = $user_profile->birthYear . '-' . $user_profile->birthMonth . '-' . $user_profile->birthMonth;
                } else {
                    $birthday = '';
                }

                // Création du compte entier
                $objUser->createUser($user_profile->email, $password, $user_profile->firstName, $user_profile->lastName, $birthday, $sex, $verification_key, $verified, $blocked, $provider, $user_profile->identifier);
            
                // Récupération du compte après création
                $user = $objUser->getExist($user_profile->email);
            }
            else {

                // Cas 2 = Un compte sur le site
                if(!$userProvider || is_null($userProvider)) {

                    $verified = true;

                    // Mise à jour de son compte
                    $objUser->fusionClassicAndProviderAccount($user->id, $user->email, $verified, $provider, $user_profile->identifier);
                }
            }

            // Connexion
            $_SESSION['user_auth'] = '1';
            $_SESSION['user_id'] = $user->id;

            // Get All Media Subscription by User
            $objWebsiteSubscription = new WebsiteSubscription($bdd, $_TABLES);
            $website_subscriptions = $objWebsiteSubscription->getAllWebsiteSubscriptionsByUser($_SESSION['user_id']);

            $temp = array();
            if($website_subscriptions) {

                foreach ($website_subscriptions as $key => $value) {
                    array_push($temp, $value->website_id);
                }
            }
            $_SESSION['user_subscription'] = $temp;

            // Retour 0
            return 0;
        }
        else {
            // Problème d'authentification
            $_SESSION['user_auth'] = '0';

            if(isset($_SESSION['user_id'])) {
                unset($_SESSION['user_id']);
            }

            if(isset($_SESSION['user_subscription'])) {
                unset($_SESSION['user_subscription']);
            }

            return 1;
        }
    }
    // something went wrong?
    catch( Exception $e )
    {
        error_log($e->getMessage());
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/404.php");
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

            // Get All Media Subscription by User
            $objWebsiteSubscription = new WebsiteSubscription($bdd, $_TABLES);
            $website_subscriptions = $objWebsiteSubscription->getAllWebsiteSubscriptionsByUser($_SESSION['user_id']);

            $temp = array();
            if($website_subscriptions) {

                foreach ($website_subscriptions as $key => $value) {
                    array_push($temp, $value->website_id);
                }
            }
            $_SESSION['user_subscription'] = $temp;

            return 0;
        }
        else {

            $_SESSION['user_auth'] = '0';

            if(isset($_SESSION['user_id'])) {
                unset($_SESSION['user_id']);
            }

            if(isset($_SESSION['user_subscription'])) {
                unset($_SESSION['user_subscription']);
            }

            return 1;
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
    unset($_SESSION['user_subscription']);
    unset($_COOKIE['user_preference']);

    return 0;
}

function lostPassword($email) {

    global $bdd;
    global $_TABLES;

    if(!is_null($bdd) && !is_null($_TABLES)) {
        
        // Requete de verification de l'existence du compte
        $objUser = new User($bdd, $_TABLES);
        $user = $objUser->getExist($email);

        if($user && !is_null($user)) {
            
            // Generation du nouveau mot de passe
            $new_password = random_password();

            // Mise à jour du mot de passe de l'utilisateur
            $objUser->updatePassword($user->id, $new_password);

            // Génération de l'email
            $template = new Template(dirname(dirname(dirname(__FILE__))) . "/ressources/template/email/reset_password.html");
            $content = $template->getView(array(
                "first_name" => $first_name,
                "last_name" => $last_name,
                "new_password" => $new_password
                ));

            // Envoi de l'email de bienvenue
            $objMailer = new Mailer();
            $objMailer->from = "postmaster@whatsup.agency";
            $objMailer->fromName = "Whats Up Street";
            $objMailer->to = $email;
            $objMailer->toName = $first_name . ' ' . $last_name;
            $objMailer->subject = "[Important] Whats Up Street : Changement mot de passe";
            $objMailer->content = $content;
            $objMailer->isHTML();
            $objMailer->send();

            // Retour 0 si tout c'est bien passé
            return 0;
        }
        else {

            // Compte n'existe pas
            return 1;
        }
    }
    else {
        error_log("BDD ERROR : " . json_encode($bdd));
        error_log("TABLES ERROR : " . json_encode($_TABLES));
    }
}

function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}

?>