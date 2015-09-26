<?php

//rund custom error log
set_error_handler("errorHandler");


function errorHandler($errno, $errstr, $errfile, $errline)
{
    $error = "";
    $path  = "../../../../application/logs/php.errors";


    switch ($errno) {
    case E_USER_ERROR:
        $erro .=  "<b>Mon ERREUR</b> [$errno] $errstr<br />\n";
        $erro .=  "  Erreur fatale sur la ligne $errline dans le fichier $errfile";
        $erro .=  ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        $erro .=  "Arrêt...<br />\n";

        break;

    case E_USER_WARNING:

        $error .=  "<b>Mon ALERTE</b> [$errno] $errstr<br />\n";
        break;

    case E_USER_NOTICE:
        $error .=   "<b>Mon AVERTISSEMENT</b> [$errno] $errstr<br />\n";
        break;

    default:
        $error .=   "Erreur [$errno] $errstr<br />\n";
        break;
    }

    
    file_put_contents($path, $errstr);

    return true;
}

?>