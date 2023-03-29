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

$router->post('/change_password', function () {
    UserController::changePassword();
});

$router->get('/forgot_password', function () {
    UserController::getForgotPasswordPage();
});

$router->post('/forgot_password', function () {
    UserController::forgotPassword();
});

$router->get('/cart', function () {
    UserController::getCartPage();
});

$router->get('/order_history', function () {
    UserController::getOrderHistoryPage();
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

$router->post('/addToCart', function () {
    UserController::addToCart();
});

$router->post('/removeFromCart', function () {
    UserController::removeFromCart();
});

$router->post('/decreaseQuantity', function () {
    UserController::decreaseQuantity();
});

$router->post('/increaseQuantity', function () {
    UserController::increaseQuantity();
});

$router->get('/cartItems', function () {
    UserController::getCartItems();
});

$router->post('/addAddress', function () {
    UserController::addAddress();
});

$router->get('/getAddress', function () {
    UserController::getAddress();
});

$router->post('/order', function () {
    UserController::order();
});
