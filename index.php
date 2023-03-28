<?php
require_once('controllers/user_controller.php');

include_once('services/request.php');
include_once('services/router.php');
session_start();
if(isset($_SERVER['PATH_INFO']))
{

    if($_SERVER['REQUEST_METHOD']=='GET')
    {
        if($_SERVER['PATH_INFO']=='/verifyEmail')
        {
            UserController::verifyEmial();   
            exit;
        }else if($_SERVER['PATH_INFO']=='/forgotPasswordUrl'){
            UserController::verifyForgotPasswordLink();
            exit;
        }
    } 
}

$router = new Router(new Request);

$router->get('/', function () {
    include('views/home.php');
});

require_once('routes/user_route.php');
require_once('routes/seller_route.php');
