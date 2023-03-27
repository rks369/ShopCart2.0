<?php
require_once('models/user_model.php');



class UserController
{
    static function authCheck()
    {
        if (!isset($_SESSION['id'])) {
            require_once('views/user/login.php');
            exit;
        } else  if ($_SESSION['id'] == '-1') {
            require_once('views/user/verify_email.php');
            exit;
        }
    }

    static function getLoginPage()
    {
        require_once('views/user/login.php');
    }

    static function getSignUpPage()
    {
        require_once('views/user/signup.php');
    }

    static function getChangePasswordPage()
    {
        self::authCheck();
        require_once('views/user/change_password.php');
    }

    static function getCartPage()
    {
        self::authCheck();
        require_once('views/user/cart.php');
    }

    static function getOrderHistoryPage()
    {
        self::authCheck();
        require_once('views/user/order_history.php');
    }

    static function getForgotPasswordPage()
    {
        require_once('views/user/login.php');
    }

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
                $_SESSION['id'] =  '-1';
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
        if ($user && $user->password == $userDetails['password']) {

            $_SESSION['id'] = $user->status == '1' ? $user->id : '-1';
            $_SESSION['name'] = $user->name;
            $_SESSION['role'] = 'user';

            $response->msg = 'Done';
            $response->data = $user->toArray();
        } else {

            $response->msg = 'Error';
            $response->data = "Credential Doesn't Match!!!";
        }


        echo json_encode($response);
    }
    static function getProductList()
    {
        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body, true);

        $curremt_index = $body['current_index'];
        $count = $body['count'];

        $productModel = new ProductModel();

        $productList =  $productModel->getProducts($curremt_index, $count);

        if (count($productList) == 0) {
            $response->msg = 'Error';
            $response->data = "No Products Available";
        } else {
            $response->msg = 'Done';
            $response->data = $productList;
        }


        echo json_encode($response);
    }

    static function getProduct()
    {
        $response = new stdClass();
        $body =  file_get_contents('php://input');
        $body = json_decode($body);
        $productModel = new ProductModel();

        $productList =  $productModel->getProduct($body->product_id);

        if (count($productList) == 0) {
            $response->msg = 'Error';
            $response->data = "No Products Available";
        } else {
            $response->msg = 'Done';
            $response->data = $productList[0];
        }


        echo json_encode($response);
    }

    static function addToCart()
    {
        $response = new stdClass();


        if(isset($_SESSION['id'])){

            $body =  file_get_contents('php://input');
            $body = json_decode($body);
    
            $userModel = new UserModel();
    
            $result =  $userModel->addToCart($_SESSION['id'], $body->product_id);
    
            if ($result == 'Error') {
                $response->msg = 'Error';
                $response->data = "Something Went Wrong !!!";
            } else {
                $response->msg = 'Done';
                $response->data = 'Add To Cart SucessFullt !!!';
            }
        }else
        {
            $response->msg = 'Error';
            $response->data = "Not Login";
        }



        echo json_encode($response);
    }

    static function logout()
    {
        session_destroy();
        header('Location: ' . './');
    }
}
