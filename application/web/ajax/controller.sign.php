<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/core/system/ajax.php');
require_once(dirname(dirname(dirname(__FILE__))) . "/common/php/class/class.user.php");
require_once(dirname(dirname(dirname(__FILE__))) . "/core/mailer/class.mailer.php");
require_once('controller.system_preference.php');

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    switch($action) {
        case 'sign' : {
            
            // Constante a mettre dans la configuration
			$g_recaptcha_secret = '6LdnahcTAAAAAIiEE2HgT0xJWcDQZvJEFrzScv2r';

			// Acquisition de toutes les variables
			(isset($_POST['first-name']) && !empty($_POST['first-name'])) ? $first_name = $_POST['first-name'] : $first_name = null;
			(isset($_POST['last-name']) && !empty($_POST['last-name'])) ? $last_name = $_POST['last-name'] : $last_name = null;
			(isset($_POST['birthday']) && !empty($_POST['birthday'])) ? $birthday = $_POST['birthday'] : $birthday = null;
			(isset($_POST['sex']) && !empty($_POST['sex'])) ? $sex = $_POST['sex'] : $sex = null;
			(isset($_POST['email']) && !empty($_POST['email'])) ? $email = $_POST['email'] : $email = null;
			(isset($_POST['email-conf']) && !empty($_POST['email-conf'])) ? $email_conf = $_POST['email-conf'] : $email_conf = null;
			(isset($_POST['password']) && !empty($_POST['password'])) ? $password = $_POST['password'] : $password = null;
			(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) ? $g_recaptcha_response = $_POST['g-recaptcha-response'] : $g_recaptcha_response = null;

			echo sign($first_name, $last_name, $birthday, $sex, $email, $email_conf, $password, $g_recaptcha_response, $g_recaptcha_secret);
			break;
        }
    }
}

function sign($first_name, $last_name, $birthday, $sex, $email, $email_conf, $password, $g_recaptcha_response, $g_recaptcha_secret) {

	global $bdd;
	global $_TABLES;

	// Requete de verification anti bot recaptcha Google
	if(captchaValid($g_recaptcha_secret, $g_recaptcha_response)) {

		// Captcha correctement validé
		error_log('Captcha Valide');

		// Verification que les emails concordent
		if($email === $email_conf) {

			error_log('Email good');

			// Mise en forme de la date d'anniversaire
			$birthday_temp = explode("/", $birthday);
			$birthday_bo = $birthday_temp[2] . '-' . $birthday_temp[1] . '-' . $birthday_temp[0];

			// Génération des variables manquantes
			$verification_key = md5(microtime(TRUE) * 100000);
			$verified = false;
			$blocked = false;
			$hybridauth_provider_name = '';
			$hybridauth_provider_uid = '';

			// Vérification de l'activation de la verification par email
			if(getSystemPreference('email_verification')->email_verification == 1) {

				error_log('Verification On');

				// Création du compte utilisateur en fonction de la verification par email
				$objUser = new User($bdd, $_TABLES);
				$user = $objUser->getExist($email);
				
				if(!$user || is_null($user)) {
					$objUser->createUser($email, $password, $first_name, $last_name, $birthday_bo, $sex, $verification_key, $verified, $blocked, $hybridauth_provider_name, $hybridauth_provider_uid);
				
					// Génération de l'email
					$template = new Template(dirname(dirname(dirname(__FILE__))) . "/ressources/template/email/welcome_verified.html");
		            $content = $template->getView(array(
		                "first_name" => $first_name,
		                "last_name" => $last_name,
		                "link_verification" => "http://" . $_SERVER['HTTP_HOST'] . "/verification/" . $verification_key
		                ));

					// Envoi de l'email de bienvenue
					$objMailer = new Mailer();
					$objMailer->from = "quentin.belot.pro@gmail.com";
					$objMailer->fromName = "Whats Up Street";
					$objMailer->to = $email;
					$objMailer->toName = $first_name . ' ' . $last_name;
					$objMailer->subject = "Bienvenue sur Whats Up Street";
					$objMailer->content = $content;
					$objMailer->isHTML();
					$objMailer->send();

					// Retour 0 si tout c'est bien passé
					return 0;
				}
				else {

					// Compte déjà existant
					return 3;
				}

			} else {

				error_log('Verification Off');

				// Pas de verification
				$verified = true;

				// Création du compte utilisateur en fonction de la verification par email
				$objUser = new User($bdd, $_TABLES);
				$user = $objUser->getExist($email);
				
				if(!$user || is_null($user)) {
					$objUser->createUser($email, $password, $first_name, $last_name, $birthday_bo, $sex, $verification_key, $verified, $blocked, $hybridauth_provider_name, $hybridauth_provider_uid);

					// Génération de l'email
					$template = new Template(dirname(dirname(dirname(__FILE__))) . "/ressources/template/email/welcome.html");
		            $content = $template->getView(array(
		                "first_name" => $first_name,
		                "last_name" => $last_name,
		                "link" => "http://" . $_SERVER['HTTP_HOST']
		                ));

					// Envoi de l'email de bienvenue
					$objMailer = new Mailer();
					$objMailer->from = "quentin.belot.pro@gmail.com";
					$objMailer->fromName = "Whats Up Street";
					$objMailer->to = $email;
					$objMailer->toName = $first_name . ' ' . $last_name;
					$objMailer->subject = "Bienvenue sur Whats Up Street";
					$objMailer->content = $content;
					$objMailer->isHTML();
					$objMailer->send();

					// Retour 0 si tout c'est bien passé
					return 0;
				}
				else {

					// Compte déjà existant
					return 3;
				}

			}

		} else {

			error_log('Email erreur');

			// Email non correspondant
			return 2;
		}

	} else {

		error_log('Captcha Erreur');

		// Captcha mal validé
		return 1;
	}
}

// Fonction de vérification du captcha
function captchaValid($secret, $response, $ip = null)
{
    if (empty($secret)) {
        return false; // Si aucun code n'est entré, on ne cherche pas plus loin
    }

    $params = [
        'secret'    => $secret,
        'response'  => $response
    ];

    if( $ip ){
        $params['remoteip'] = $ip;
    }

    $url = "https://www.google.com/recaptcha/api/siteverify?" . http_build_query($params);
    /*if (function_exists('curl_version')) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Evite les problèmes, si le ser
        $response = curl_exec($curl);
    } else {
        // Si curl n'est pas dispo, un bon vieux file_get_contents
        $response = file_get_contents($url);
    }*/

    $response = file_get_contents($url);

    if (empty($response) || is_null($response)) {
        return false;
    }

    $json = json_decode($response);

    return $json->success;
}


?>