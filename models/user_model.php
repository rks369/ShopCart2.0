<?php

require_once('services/db_config.php');

class User
{
    public string $id;
    public string $name;
    public string $email;
    public string $mobile;
    public string $password;
    public string $status;


    public function __construct(array $data)
    {
        $this->id = $data['user_id'] ?? '-1';
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->mobile = $data['mobile'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->status = $data['status'] ?? '';
    }


    public function toArray()
    {
        $userDetails = [];

        $userDetails['name'] = $this->name;
        $userDetails['email'] = $this->email;
        $userDetails['mobile'] = $this->mobile;
        $userDetails['password'] = $this->password;
        return $userDetails;
    }
}

class UserModel
{

    private $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function addUser(array $details): string
    {
        return $this->db->insert('users', $details);
    }

    public function getUser(string $email): User|NULL
    {
        $condition = array();

        $condition['email'] = $email;
        $ret = $this->db->select('users', $condition);

        if ($ret) {
            $user = new User($ret[0]);
            return $user;
        }
        return NULL;
    }
}
