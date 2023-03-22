<?php

require_once('services/db_config.php');

class User
{
}

class UserModel
{

    private $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function addUser(string $name, string $email, string $mobile, string $password)
    {

        $sql = <<<EOF
        INSERT INTO USERS(NAME,EMAIL,MOBILE,PASSWORD) 
        VALUES('$name','$email','$mobile','$password');
  EOF;
  $db = new DataBase();
        $ret = $db->excecuteQuery($sql);

        echo $ret;
    }
}
