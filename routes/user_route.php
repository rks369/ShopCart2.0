<?php
require_once('models/user_model.php');
$router->get('/login', function () {
    if (isset($_SESSION['user_id'])) {
        echo "Logged in";
    } else {

        include('views/user/login.php');
    }
});

$router->get('/signup', function () {
    include('views/user/signup.php');
});

$router->get('/change_password', function () {
    include('views/user/change_password.php');
});

$router->get('/forgot_password', function () {
    include('views/user/forgot_password.php');
});

$router->post('/signup', function ($request) {
    $body =  file_get_contents('php://input');
    $body = json_decode($body);

    $userModel = new UserModel();

    $result = $userModel->addUser($body->name,$body->email,$body->mobile,$body->password);
    
    $_SESSION['id']=4;
    return json_encode("{msg:'sucess',data:$result}");
});
