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

    
    public function getSellerByID(string $id): Seller|NULL
    {
        $ret = $this->db->select('sellers', ['seller_id' => $id]);

        if ($ret) {
            $user = new Seller($ret[0]);
            return $user;
        }
        return NULL;
    }


    public function getOrders(string $seller_id,int $current_index,int $row_count)
    {

       try{
           return $this->db->execute("SELECT order_item_id, name,products.product_id,products.title,quantity,address,order_time,activity FROM orders JOIN ORDER_ITEMS ON orders.order_id = order_items.order_id JOIN products ON products.product_id = order_items.product_id JOIN users ON users.user_id = orders.user_id JOIN address ON orders.billing_address=address.address_id WHERE products.seller_id =$seller_id ORDER BY order_time DESC LIMIT $row_count OFFSET $current_index;");
       }catch(Exception $e)
       {
        echo $e;
        return 'error';
       }
    }

    public function updateOrderStatus(string $order_item_id,$status)
    {

       try{
           return $this->db->execute("UPDATE order_items SET activity = '$status' WHERE order_item_id = $order_item_id");
       }catch(Exception $e)
       {
        echo $e;
        return 'error';
       }
    }

    public function getSellerByToken(string $token): Seller|NULL
    {
        $condition = array();

        $condition['token'] = $token;
        $ret = $this->db->select('sellers', $condition);

        if ($ret) {
            $user = new Seller($ret[0]);
            return $user;
        }
        return NULL;
    }

    public function updateStatus(string $seller_id, string $status)
    {
        return $this->db->update('sellers', ['status' => $status], ['seller_id' => $seller_id]);
    }

    public function updaetToken(string $seller_id, string $token)
    {
        return $this->db->update('sellers', ['token' => $token], ['seller_id' => $seller_id]);
    }

    public function changePassword(string $seller_id, string $password)
    {
        return $this->db->update('sellers', ['password' => $password], ['seller_id' => $seller_id]);
    }

}
