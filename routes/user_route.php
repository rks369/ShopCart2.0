<?php
require_once('controllers/user_controller.php');

$router->get('/login', function () {
    UserController::getLoginPage();
});

$router->get('/signup', function () {
    UserController::getSignUpPage();
});

$router->get('/change_password', function () {
  UserController::getChangePasswordPage();
});

$router->get('/forgot_password', function () {
    UserController::getForgotPasswordPage();
});

$router->post('/signup', function ($request) {
    UserController::signUp();
});

$router->post('/login', function ($request) {
    UserController::login();
});

$router->get('/logout', function ($request) {
    UserController::logout();
});