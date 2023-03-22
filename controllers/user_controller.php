<?php
require_once ('models/user_model.php');

class UserController{
    static function signUp(){
        $userModel = new UserModel();

        $userModel->addUser('Rk','vheufh','chwu','dscc');

        require_once('views/user/login.php');
    }
}