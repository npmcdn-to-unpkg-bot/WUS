<?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_SESSION['user_auth']) && $_SESSION['user_auth'] == '1') {
        require('account-verification.php');
    } else {
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/");
    }

?>