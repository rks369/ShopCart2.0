<?php
require_once('models/user_model.php');

class UserController
{
    static function signUp()
    {

        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body);

        $userModel = new UserModel();

        $userDetails = [];

        $userDetails['name'] = $body->name;
        $userDetails['email'] = $body->email;
        $userDetails['mobile'] = $body->mobile;
        $userDetails['password'] = $body->password;

        $user = $userModel->getUser($body->email);

        if ($user) {
            $response->msg = 'Error';
            $response->data = 'User Already Exits!!!';
        } else {

            $result = $userModel->addUser($userDetails);
            if ($result) {
                $_SESSION['id'] = -1;
                $_SESSION['name'] = $userDetails['name'];
                $response->msg = 'Done';
                $response->data = 'User Added Sucessfully!!!';
            } else {
                $response->msg = 'Error';
                $response->data = 'Something Went Wrong !!!';
            }
        }


        echo json_encode($response);
    }
    static function login()
    {

        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body);

        $userModel = new UserModel();

        $userDetails = [];

        $userDetails['email'] = $body->email;
        $userDetails['password'] = $body->password;

        $user = $userModel->getUser($body->email);

        if ($user && $user->password === $userDetails['password']) {
            $_SESSION['id']=$user->id;
            $_SESSION['name']=$user->name;
            $response->msg = 'Done';
            $response->data = $user->toArray();
        } else {

            $response->msg = 'Error';
            $response->data = "Credential Doesn't Match!!!";
        }


        echo json_encode($response);
    }

    static function logout(){
        session_destroy();
        header('Location: '.'./');
    }
}
