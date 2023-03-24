<?php
require_once('models/seller_model.php');

class SellerController

{
    static function authCheck()
    {
        if (!isset($_SESSION['id'])) {
            require_once('views/seller/login.php');
            exit;
        } else  if ($_SESSION['id'] == '-1') {
            require_once('views/seller/verify_email.php');
            exit;
        } else  if ($_SESSION['role'] != 'seller') {
            echo 'Acess Denied';
            exit;
        }
    }
    static function getLoginPage()
    {
        self::authCheck();
        include('views/seller/login.php');
    }
    static function getSignUpPage()
    {        self::authCheck();

        include('views/seller/signup.php');
    }
    static function getChangePasswordPage()
    {        self::authCheck();

        include('views/seller/change_password.php');
    }
    static function getForgotPasswordPage()
    {
        include('views/seller/forgot_password.php');
    }
    static function signUp()
    {

        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body, true);

        $body = new  Seller($body);

        $sellerModel = new SellerModel();


        $seller = $sellerModel->getSeller($body->email);

        if ($seller) {
            $response->msg = 'Error';
            $response->data = 'User Already Exits!!!';
        } else {

            $result = $sellerModel->addSeller($body->toArray());
            if ($result) {
                $_SESSION['id'] = '-1';
                $_SESSION['name'] = $body->seller_name;
                $_SESSION['role'] = 'seller';
                $response->msg = 'Done';
                $response->data = 'Seller Added Sucessfully!!!';
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
        $body = json_decode($body, true);

        $body = new Seller($body);

        $sellerModel = new SellerModel();



        $seller = $sellerModel->getSeller($body->email);

        if ($seller && $seller->password === $body->password) {
            $_SESSION['id'] = $seller->status == '1' ? $seller->seller_id : '-1';
            $_SESSION['name'] = $seller->seller_name;
            $_SESSION['role'] = 'seller';
            $response->msg = 'Done';
            $response->data = $seller->toArray();
        } else {

            $response->msg = 'Error';
            $response->data = "Credential Doesn't Match!!!";
        }


        echo json_encode($response);
    }

    static function logout()
    {
        session_destroy();
        header('Location: ' . './');
    }
}
