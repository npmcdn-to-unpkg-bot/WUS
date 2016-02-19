<?php

//home root
$app->get('/', function () {
    //load page config and html content
    $page   = new Page('home');
});

//bar page
$app->get('/to/:to', function ($to) {
    //load page config and html content
    $page   = new Page('bar');
});

//legale page
$app->get('/legale/:name', function ($name) {
    //load page config and html content
    $page   = new Page('legale');
});

// account page
$app->get('/account', function () {
    //load page config and html content
    $page   = new Page('account');
});

/////////////////
// ADMIN PAGE  //
/////////////////

//home root
$app->get('/admin', function () {
    //load page config and html content
    $page = new PageAdmin('index');
});

$app->get('/admin/modules/category', function () {
    //load page config and html content
    require(dirname(dirname(__FILE__)) . "/admin/modules/category/index.php");
});

$app->get('/admin/modules/category_preference', function () {
    //load page config and html content
    require(dirname(dirname(__FILE__)) . "/admin/modules/category_preference/index.php");
});

$app->get('/admin/modules/collaboration', function () {
    //load page config and html content
    require(dirname(dirname(__FILE__)) . "/admin/modules/collaboration/index.php");
});

$app->get('/admin/modules/item', function () {
    //load page config and html content
    require(dirname(dirname(__FILE__)) . "/admin/modules/item/index.php");
});

$app->get('/admin/modules/static_page', function () {
    //load page config and html content
    require(dirname(dirname(__FILE__)) . "/admin/modules/static_page/index.php");
});

$app->get('/admin/modules/system_preference', function () {
    //load page config and html content
    require(dirname(dirname(__FILE__)) . "/admin/modules/system_preference/index.php");
});

$app->get('/admin/modules/type_item', function () {
    //load page config and html content
    require(dirname(dirname(__FILE__)) . "/admin/modules/type_item/index.php");
});

$app->get('/admin/modules/user', function () {
    //load page config and html content
    require(dirname(dirname(__FILE__)) . "/admin/modules/user/index.php");
});

$app->get('/admin/modules/website', function () {
    //load page config and html content
    require(dirname(dirname(__FILE__)) . "/admin/modules/website/index.php");
});

$app->get('/admin/modules/website_category', function () {
    //load page config and html content
    require(dirname(dirname(__FILE__)) . "/admin/modules/website_category/index.php");
});

$app->get('/admin/modules/website_subscription', function () {
    //load page config and html content
    require(dirname(dirname(__FILE__)) . "/admin/modules/website_subscription/index.php");
});

?>