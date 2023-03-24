<?php
require_once('controllers/seller_controller.php');

$router->get('/seller', function () {

    SellerController::getDashBoardPage();
});

$router->get('/seller/login', function () {
    SellerController::getLoginPage();
});

$router->get('/seller/signup', function () {
    SellerController::getSignUpPage();
});

$router->get('/seller/change_password', function () {
    SellerController::getChangePasswordPage();
});

$router->get('/seller/forgot_password', function () {
    SellerController::getForgotPasswordPage();
});

$router->post('/seller/signup', function () {
    SellerController::signUp();
});
$router->post('/seller/login', function () {
    SellerController::login();
});
$router->get('/seller/logout', function () {
    SellerController::logout();
});

$router->post('/seller/products', function () {
    SellerController::authCheck();
    SellerController::getProductList();
});
$router->post('/seller/addProduct', function () {
    SellerController::addProduct();
});