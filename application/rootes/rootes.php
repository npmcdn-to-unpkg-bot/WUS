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

$app->get('/admin/modules/website_category', function () {
    //load page config and html content
    include(dirname(dirname(__FILE__)) . "/admin/modules/website_category/index.php");
});

$app->get('/admin/modules/category', function () {
    //load page config and html content
    include(dirname(dirname(__FILE__)) . "/admin/modules/category/index.php");
});

$app->get('/admin/modules/category_preference', function () {
    //load page config and html content
    include(dirname(dirname(__FILE__)) . "/admin/modules/category_preference/index.php");
});

?>