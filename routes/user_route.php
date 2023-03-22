<?php
require_once('controllers/user_controller.php');
$router->get('/login', function () {
    require_once('views/user/login.php');
});

$router->get('/signup', function () {
    include('views/user/signup.php');
});

$router->get('/change_password', function () {
    authCheck();
    include('views/user/change_password.php');
});

$router->get('/forgot_password', function () {
    include('views/user/forgot_password.php');
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