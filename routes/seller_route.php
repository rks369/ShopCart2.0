<?php
$router->get('/seller/login', function () {
    include('views/seller/login.php');
});

$router->get('/seller/signup', function () {
    include('views/seller/signup.php');
});

$router->get('/seller/change_password', function () {
    include('views/seller/change_password.php');
});

$router->get('/seller/forgot_password', function () {
    include('views/seller/forgot_password.php');
});