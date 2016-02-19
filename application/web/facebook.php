<?php

require_once(dirname(__FILE__) . '/ajax/controller.login.php');

loginByProvider("Facebook");

header("Location: http://" . $_SERVER['HTTP_HOST'] . "/");

?>