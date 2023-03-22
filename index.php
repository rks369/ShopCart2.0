<?php
require_once('controllers/user_controller.php');

include_once ('services/request.php');
include_once ('services/router.php');
$router = new Router(new Request);

$router->get('/', function () {
    include('views/home.php');
});

require_once ('routes/user_route.php');
require_once ('routes/seller_route.php');

