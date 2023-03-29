<?php
require_once('models/user_model.php');

require_once('services/send_emial.php');

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
        require_once('views/user/forgot_password.php');
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
        $userDetails['token'] = time();

        $user = $userModel->getUser($body->email);


        if ($user) {
            $response->msg = 'Error';
            $response->data = 'User Already Exits!!!';
        } else {

            $mailBody = <<<TEXT
                <h1>Verify Your Mail First !!!</h1?
    
                <h3><a href='http://localhost:8000/verifyEmail?token=${userDetails['token']}' >Verify</a></h3>
            TEXT;

            $isSent = sendMail($userDetails['email'], $userDetails['name'], 'Verify your Email !!!', $mailBody);

            if ($isSent) {
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
            } else {
                $response->msg = 'Error';
                $response->data = "Can't Able To Send Mail At This time.Please Try After Sometime";
            }
        }


        echo json_encode($response);
    }

    static function verifyEmial()
    {
        $token = $_GET['token'];

        $userModel = new UserModel();

        $user = $userModel->getUserByToken($token);
        $message = '';
        if ($user) {
            $result = $userModel->updateStatus($user->id, 1);
            if ($result) {

                $message = "Mail Is Verified";
            } else {
                $message = "Something Went Wrong";
            }
        } else {
            $message = "Invalid Credentials";
        }

        require_once('views/user/verify_email.php');
    }

    static function verifyForgotPasswordLink()
    {
        $token = $_GET['token'];

        $userModel = new UserModel();

        $user = $userModel->getUserByToken($token);
        if ($user) {
            $_SESSION['id'] = $user->id;
            $_SESSION['forgot'] = true;
            require_once('views/user/change_password.php');
        } else {
            $message = "Invalid Credentials";
            require_once('views/user/verify_email.php');
        }
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

    static function changePassword()
    {

        $response = new stdClass();

        $body = file_get_contents('php://input');
        $body = json_decode($body, true);

        $userModel = new UserModel();
        $user = $userModel->getUserByID($_SESSION['id']);
        $result = $userModel->changePassword($_SESSION['id'], $body['password']);
        if ($result) {
            $mailBody = <<<TEXT
            <h1>Password Changed Sucessfully !!!</h1>

            <h3><a href='login' >Login</a></h3>
        TEXT;

            $isSent = sendMail($user->email, $user->name, 'Password Chnaged Sucessfully !!!', $mailBody);

            if ($isSent) {
                $response->msg = "Done";
                $response->data = "Password Changed Sucessfully !!!";
            } else {
                $response->msg = "Done";
                $response->data = "Can't Able to send Mail At This Time";
            }

            if (isset($_SESSION['forgot'])) {
                session_destroy();
            }
        } else {
            $response->msg = "Error";
            $response->data = "Password Not Changed !!!";
        }

        echo json_encode($response);
    }

    static function forgotPassword()
    {

        $response = new stdClass();

        $body = file_get_contents('php://input');
        $body = json_decode($body, true);

        $userModel = new UserModel();
        $user = $userModel->getUser($body['email']);
        if ($user) {

            $newToken = time();

            $updateToken = $userModel->updaetToken($user->id, $newToken);
            if ($updateToken) {
                $mailBody = <<<TEXT
                <h1>Reset Your Password!!</h1?
    
                <h3><a href='http://localhost:8000/forgotPasswordUrl?token=${newToken}' >Reset</a></h3>
            TEXT;
                $isSent = sendMail($user->email, $user->name, 'Reset your Password!!!', $mailBody);

                if ($isSent) {
                    $response->msg = "Done";
                    $response->data = "Password Changed Sucessfully !!!";
                } else {
                    $response->msg = "Done";
                    $response->data = "Can't Able to send Mail At This Time";
                }
            } else {
                $response->msg = "Error";
                $response->data = "Something went Wrong!!!";
            }
        } else {
            $response->msg = "Error";
            $response->data = "No Account Found With This Email !!!";
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

        if (isset($_SESSION['id'])) {

            $body =  file_get_contents('php://input');
            $body = json_decode($body);

            $userModel = new UserModel();

            $result =  $userModel->addToCart($_SESSION['id'], $body->product_id);

            if ($result == 'Error') {
                $response->msg = 'Error';
                $response->data = "Something Went Wrong !!!";
            } else {
                $response->msg = 'Done';
                $response->data = 'Add To Cart SucessFully !!!';
            }
        } else {
            $response->msg = 'Error';
            $response->data = "Not Login";
        }

        echo json_encode($response);
    }

    static function removeFromCart()
    {
        $response = new stdClass();

        if (isset($_SESSION['id'])) {

            $body =  file_get_contents('php://input');
            $body = json_decode($body);

            $userModel = new UserModel();

            $result =  $userModel->removeFromCart($_SESSION['id'], $body->product_id);

            if ($result == 'Error') {
                $response->msg = 'Error';
                $response->data = "Something Went Wrong !!!";
            } else {
                $response->msg = 'Done';
                $response->data = 'Remove From Cart SucessFully !!!';
            }
        } else {
            $response->msg = 'Error';
            $response->data = "Not Login";
        }

        echo json_encode($response);
    }
    static function decreaseQuantity()
    {
        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body);

        $userModel = new UserModel();

        $result =  $userModel->decreaseQuantity($body->cart_id);

        if ($result == 'Error') {
            $response->msg = 'Error';
            $response->data = "Something Went Wrong !!!";
        } else {
            $response->msg = 'Done';
            $response->data = 'Decrease Cart item By 1 SucessFully !!!';
        }

        echo json_encode($response);
    }
    static function increaseQuantity()
    {
        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body);

        $userModel = new UserModel();

        $result =  $userModel->increaseQuantity($body->cart_id);

        if ($result == 'Error') {
            $response->msg = 'Error';
            $response->data = "Something Went Wrong !!!";
        } else if ($result == 'Out Of Stock') {
            $response->msg = 'Error';
            $response->data = 'Item Is Out Of Stock !!!';
        } else {
            $response->msg = 'Done';
            $response->data = 'Increase Cart item By 1 SucessFully !!!';
        }

        echo json_encode($response);
    }

    static function getCartItems()
    {
        $response = new stdClass();

        if (isset($_SESSION['id'])) {

            $userModel = new UserModel();

            $result =  $userModel->cartItems($_SESSION['id']);

            if ($result) {
                $response->msg = 'Done';
                $response->data = $result;
            } else {
                $response->msg = 'Error';
                $response->data = "Something Went Wrong !!!";
            }
        } else {
            $response->msg = 'Error';
            $response->data = "Not Login";
        }

        echo json_encode($response);
    }

    static function addAddress()
    {
        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body);

        $userModel = new UserModel();

        $result =  $userModel->addAddress($_SESSION['id'], $body->address);
        $res = $userModel->getAddress($_SESSION['id']);
        $res = array_reverse($res);
        if ($result) {
            $response->msg = 'Done';
            $response->data = $res[0];
        } else {
            $response->msg = 'Error';
            $response->data = "Something Went Wrong !!!";
        }

        echo json_encode($response);
    }

    static function getAddress()
    {
        $response = new stdClass();


        $userModel = new UserModel();

        $result =  $userModel->getAddress($_SESSION['id']);

        if ($result) {
            $response->msg = 'Done';
            $response->data = $result;
            $response->result = $result;
        } else {
            $response->msg = 'Error';
            $response->data = "Something Went Wrong !!!";
        }

        echo json_encode($response);
    }

    static function order()
    {
        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body,true);

        $userModel = new UserModel();

        $result = $userModel->order($_SESSION['id'],$body['cart_id_list'],$body['billing_address']);

        $response->msg = 'Done';
        $response->data = $result;

        echo json_encode($response);
    }

    static function getOrderHistory()
    {
        $response = new stdClass();

        $userModel = new UserModel();

        $result = $userModel->orderHistory($_SESSION['id']);
        if($result)
        {
            $response->msg = 'Done';
            $response->data = $result;
        }else{
         
            $response->msg = 'Error';
            $response->data = 'Something Went Wrong !!!';   
        }

        echo json_encode($response);
    }

    static function getOrderDetails()
    {
        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body,true);

        $userModel = new UserModel();


        $result = $userModel->orderDetails($body['order_id']);
        if($result)
        {
            $response->msg = 'Done';
            $response->data = $result;
        }else{
         
            $response->msg = 'Error';
            $response->data = 'Something Went Wrong !!!';   
        }

        echo json_encode($response);
    }

    static function logout()
    {
        session_destroy();
        header('Location: ' . './');
    }
}
