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
        self::authCheck();

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

    static function getProductList()
    {
        $response = new stdClass();

        $body =  file_get_contents('php://input');
        $body = json_decode($body, true);

        $curremt_index = $body['current_index'];
        $count = $body['count'];

        if (self::authCheckMsg() == 'allowed') {
            $productModel = new ProductModel();

            $productList =  $productModel->getSellerProducts($curremt_index,$count);

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

            $result =  $productModel->updateStatus($product_id,$status);

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

    static function logout()
    {
        session_destroy();
        header('Location: ' . './');
    }
}
