<?php
require_once('controllers/user_controller.php');
require_once('controllers/seller_controller.php');

$router->get('/login', function () {
    UserController::getLoginPage();
});

$router->get('/signup', function () {
    UserController::getSignUpPage();
});

$router->get('/change_password', function () {
    UserController::authCheck();
    UserController::getChangePasswordPage();
});

$router->get('/forgot_password', function () {
    UserController::getForgotPasswordPage();
});

$router->post('/signup', function () {
    UserController::signUp();
});

$router->post('/login', function () {
    UserController::login();
});

$router->get('/logout', function () {
    UserController::logout();
});

$router->post('/product', function () {
    UserController::getProductList();
});
$router->post('/getProduct', function () {
    UserController::getProduct();
});
