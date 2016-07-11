<?php

// Default headers
header("X-Content-Type-Options: nosniff");

// LOAD SLIM FRAMEWORK AND REQUIRED LIBRARIES
require "application/library/Slim/Slim.php";
require "application/core/system/api.php";
// require "application/core/system/class.error.handler.php";
require "application/core/system/template.php";
require "application/core/system/page.php";
require "application/core/system/pageadmin.php";
require "application/core/mysql/class.mysql.php";


// CREATE NEW SLIM APP
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

//load api and global config
$api    = new API();

//data base connection 
$bdd = $api->bdd;
$_TABLES = $api->_TABLES;
$config = $api->config;

//load rootes
require "application/rootes/rootes.php";

// RUN THE APP
$app->run();

?>