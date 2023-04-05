<?php
require_once('models/seller_model.php');
require_once('models/product_model.php');

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
    static function authCheckMsg()
    {
        if (!isset($_SESSION['id'])) {
            return  'Not Login';
        } else  if ($_SESSION['id'] == '-1') {
            return 'Not a Valid User';
        } else  if ($_SESSION['role'] != 'seller') {
            return 'Acess Denied';
        } else {
            return 'allowed';
        }
    }

    static function getDashBoardPage()
    {
        self::authCheck();
        include('views/seller/dashboard.php');
    }

    static function getLoginPage()
    {
        self::authCheck();
        include('views/seller/login.php');
    }

    static function getSignUpPage()
    {

        include('views/seller/signup.php');
    }

    static function getChangePasswordPage()
    {
        self::authCheck();

        include('views/seller/change_password.php');
    }

    static function getForgotPasswordPage()
    {
        include('views/seller/forgot_password.php');
    }

    static function getOrdersPage()
    {
        require_once('views/seller/product_orders.php');
        exit;
    }

    static function signUp()
    {

        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body, true);
        $body['token'] = time();
        $body = new  Seller($body);

        $sellerModel = new SellerModel();


        $seller = $sellerModel->getSeller($body->email);

        if ($seller) {
            $response->msg = 'Error';
            $response->data = 'User Already Exits!!!';
        } else {

            $mailBody = <<<TEXT
            <h1>Verify Your Mail First !!!</h1?

            <h3><a href='http://localhost:8000/seller/verifyEmail?token=$body->token' >Verify</a></h3>
        TEXT;

            $isSent = sendMail($body->email, $body->seller_name, 'Verify your Email !!!', $mailBody);

            if ($isSent) {
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
            } else {
                $response->msg = 'Error';
                $response->data = "Can't Able To Send Mail At This time.Please Try After Sometime";
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


    static function forgotPassword()
    {

        $response = new stdClass();

        $body = file_get_contents('php://input');
        $body = json_decode($body, true);

        $sellerModel = new SellerModel();
        $seller = $sellerModel->getSeller($body['email']);
        if ($seller) {

            $newToken = time();

            $updateToken = $sellerModel->updaetToken($seller->seller_id, $newToken);
            if ($updateToken) {
                $mailBody = <<<TEXT
                <h1>Reset Your Password!!</h1?
    
                <h3><a href='http://localhost:8000/seller/forgotPasswordUrl?token=${newToken}' >Reset</a></h3>
            TEXT;
                $isSent = sendMail($seller->email, $seller->seller_name, 'Reset your Password!!!', $mailBody);

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

    static function changePassword()
    {

        $response = new stdClass();

        $body = file_get_contents('php://input');
        $body = json_decode($body, true);

        $sellerModel = new SellerModel();
        
        $seller = $sellerModel->getSellerByID($_SESSION['id']);
        $result = $sellerModel->changePassword($_SESSION['id'], $body['password']);
        if ($result) {
            $mailBody = <<<TEXT
            <h1>Password Changed Sucessfully !!!</h1>

            <h3><a href='login' >Login</a></h3>
        TEXT;

            $isSent = sendMail($seller->email, $seller->seller_name, 'Password Chnaged Sucessfully !!!', $mailBody);

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

    static function verifyEmial()
    {
        $token = $_GET['token'];

        $sellerModel = new SellerModel();

        $seller = $sellerModel->getSellerByToken($token);
        $message = '';
        if ($seller) {
            $result = $sellerModel->updateStatus($seller->seller_id, 1);
            if ($result) {
                
                $message = "Mail Is Verified";
            } else {
                $message = "Something Went Wrong";
            }
        } else {
            $message = "Invalid Credentials";
        }

        require_once('views/seller/verify_email.php');
    }

    static function verifyForgotPasswordLink()
    {
        $token = $_GET['token'];

        $sellerModel = new SellerModel();

        $seller = $sellerModel->getSellerByToken($token);
        if ($seller) {
            $_SESSION['id'] = $seller->seller_id;
            $_SESSION['forgot'] = true;
            require_once('views/seller/change_password.php');
        } else {
            session_destroy();
            $message = "Invalid Credentials";
            require_once('views/seller/verify_email.php');
        }
    }

    static function addProduct()
    {
        $response = new stdClass();

        $body = $_POST;
        $body['seller_id'] = $_SESSION['id'];
        $file = $_FILES['image'];
        $file['name'] = $_SESSION['id'] . time() . '.png';
        $body['imageurl'] = $file['name'];
        move_uploaded_file($file['tmp_name'], 'uploads/' . $file['name']);

        $product = new Product($body);

        $productModel = new ProductModel();
        $productModel->addProduct($product->toArray());

        if ($productModel) {
            $response->msg = 'Done';
            $response->body = $body;
        } else {
            $response->msg = 'Error';
            $response->body = 'Enable to Add Product At This Time';
        }
        echo json_encode($response);
    }

    static function editProduct()
    {
        $response = new stdClass();

        $body = $_POST;
        $product_id = $_POST['product_id'];
        if (isset($_FILES['image'])) {
            $file = $_FILES['image'];
            $file['name'] = $_SESSION['id'] . time() . '.png';
            $body['imageurl'] = $file['name'];
            move_uploaded_file($file['tmp_name'], 'uploads/' . $file['name']);
        }

        $product = new Product($body);

        $productModel = new ProductModel();
        $productModel->editProduct($product_id, $product->getupdateArray());

        if ($productModel) {
            $response->msg = 'Done';
            $response->body = $body;
        } else {
            $response->msg = 'Error';
            $response->body = 'Enable to Add Product At This Time';
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

        if (self::authCheckMsg() == 'allowed') {
            $productModel = new ProductModel();

            $productList =  $productModel->getSellerProducts($curremt_index, $count);

            if (count($productList) == 0) {
                $response->msg = 'Error';
                $response->data = "No Products Available";
            } else {
                $response->msg = 'Done';
                $response->data = $productList;
            }
        } else {
            $response->msg = 'Error';
            $response->data = self::authCheckMsg();
        }

        echo json_encode($response);
    }

    static function updateProductStatus()
    {
        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body, true);

        $product_id = $body['product_id'];
        $status = $body['status'];

        if (self::authCheckMsg() == 'allowed') {
            $productModel = new ProductModel();

            $result =  $productModel->updateStatus($product_id, $status);

            if ($result == 'Sucess') {
                $response->msg = 'Done';
                $response->data = "Product Status Changed!!!";
            } else {
                $response->msg = 'Error';
                $response->data = 'Something Went Wrong !!!';
            }
        } else {
            $response->msg = 'Error';
            $response->data = self::authCheckMsg();
        }

        echo json_encode($response);
    }

    static function productOrders()
    {
        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body, true);

        $product_id = $body['product_id'];

        $productModel = new ProductModel();

        $result =  $productModel->productOrders($product_id);

        if ($result) {
            $response->msg = 'Done';
            $response->data = $result;
        } else {
            $response->msg = 'Error';
            $response->data = 'Something Went Wrong !!!';
        }


        echo json_encode($response);
    }

    static function orders()
    {
        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body, true);

        $curremt_index = $body['current_index'];
        $row_count = $body['row_count'];

        $sellerModel = new SellerModel();

        $result =  $sellerModel->getOrders($_SESSION['id'], $curremt_index, $row_count);

        if ($result != 'error') {
            $response->msg = 'Done';
            $response->data = $result;
        } else {
            $response->msg = 'Error';
            $response->data = 'Something Went Wrong !!!';
        }


        echo json_encode($response);
    }

    static function updateOrderStatus()
    {
        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body, true);

        $order_item_id = $body['order_item_id'];
        $status = json_encode($body['status']);

        $sellerModel = new SellerModel();

        $result =  $sellerModel->updateOrderStatus($order_item_id, $status);

        if ($result != 'error') {
            $response->msg = 'Done';
            $response->data = $result;
        } else {
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
