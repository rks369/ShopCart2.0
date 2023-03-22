<?php
require_once('controllers/user_controller.php');

include_once('services/request.php');
include_once('services/router.php');
$router = new Router(new Request);
session_start();

function authCheck()
{
    if (!isset($_SESSION['id'])) {
        require_once('views/user/login.php');
        exit;
    } else  if ($_SESSION['id'] === '-1') {
        require_once('views/user/verify_email.php');
        exit;
    }
}

$router->get('/', function () {
    authCheck();
    include('views/home.php');
});

require_once('routes/user_route.php');
require_once('routes/seller_route.php');
