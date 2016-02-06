<?php

require_once(dirname(__FILE__) . '/ajax/controller.login.php');

loginByProvider("Facebook");

header("Location: http://local.wus.dev/");

?>