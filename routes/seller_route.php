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

$router->post('/seller/change_password', function () {
    SellerController::changePassword();
});

$router->get('/seller/forgot_password', function () {
    SellerController::getForgotPasswordPage();
});

$router->post('/seller/forgot_password', function () {
    SellerController::forgotPassword();
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
    SellerController::getProductList();
});

$router->post('/seller/addProduct', function () {
    SellerController::addProduct();
});

$router->post('/seller/editProduct', function () {
    SellerController::editProduct();
});

$router->post('/seller/updateProductStatus', function () {
    SellerController::updateProductStatus();
});

$router->post('/seller/productOrders', function () {
    SellerController::productOrders();
});

$router->get('/seller/orders', function () {
    SellerController::getOrdersPage();
});

$router->post('/seller/orders', function () {
    SellerController::orders();
});

$router->post('/seller/updateOrderStatus', function () {
    SellerController::updateOrderStatus();
});