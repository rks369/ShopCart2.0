<?php

require_once('services/db_config.php');

class Seller
{
    public string $seller_id;
    public string $seller_name;
    public string $bussiness_name;
    public string $email;
    public string $mobile;
    public string $gst;
    public string $address;
    public string $password;
    public string $status;


    public function __construct(array $data)
    {
        $this->seller_id = $data['seller_id'] ?? '-1';
        $this->seller_name = $data['seller_name'] ?? '';
        $this->bussiness_name = $data['bussiness_name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->mobile = $data['mobile'] ?? '';
        $this->gst = $data['gst'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->status = $data['status'] ?? '';
    }


    public function toArray()
    {
        $userDetails = [];

        $userDetails['seller_name'] = $this->seller_name;
        $userDetails['bussiness_name'] = $this->bussiness_name;
        $userDetails['email'] = $this->email;
        $userDetails['mobile'] = $this->mobile;
        $userDetails['gst'] = $this->gst;
        $userDetails['password'] = $this->password;
        return $userDetails;
    }
}

class SellerModel
{

    private $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function addSeller(array $details): string
    {
        return $this->db->insert('sellers', $details);
    }

    public function getSeller(string $email): Seller|NULL
    {
        $condition = array();

        $condition['email'] = "$email";
        $ret = $this->db->select('sellers', $condition);

        if ($ret) {
            $seller = new Seller($ret[0]);
            return $seller;
        }
        return NULL;
    }
}
