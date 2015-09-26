<?php

//home root
$app->get('/', function () {
    //load page config and html content
    $page   = new Page('home');
});

//home root
$app->get('/to/:to', function ($to) {
    //load page config and html content
    $page   = new Page('bar');
});

/////////////////
// ADMIN PAGE  //
/////////////////

//home root
$app->get('/admin', function () {
    //load page config and html content
    $page = new PageAdmin('index');
});

$app->get('/admin/modules/website', function () {
    //load page config and html content
    include(dirname(dirname(__FILE__)) . "/admin/modules/website/index.php");
});

?>