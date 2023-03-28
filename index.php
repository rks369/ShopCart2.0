<?php
require_once('controllers/user_controller.php');

include_once('services/request.php');
include_once('services/router.php');
if(isset($_SERVER['PATH_INFO']))
{

    if($_SERVER['REQUEST_METHOD']=='GET' && $_SERVER['PATH_INFO']=='/verifyEmail')
    {
        UserController::verifyEmial();   
        exit;
    }
}

$router = new Router(new Request);
session_start();

$router->get('/', function () {
    include('views/home.php');
});

require_once('routes/user_route.php');
require_once('routes/seller_route.php');
