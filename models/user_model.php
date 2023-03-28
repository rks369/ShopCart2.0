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
        $ret = $this->db->select('users', ['email'=>$email]);

        if ($ret) {
            $user = new User($ret[0]);
            return $user;
        }
        return NULL;
    }

    public function getUserByID(string $id): User|NULL
    {
        $ret = $this->db->select('users', ['user_id'=>$id]);

        if ($ret) {
            $user = new User($ret[0]);
            return $user;
        }
        return NULL;
    }

    public function getUserByToken(string $token): User|NULL
    {
        $condition = array();

        $condition['token'] = $token;
        $ret = $this->db->select('users', $condition);

        if ($ret) {
            $user = new User($ret[0]);
            return $user;
        }
        return NULL;
    }

    public function updateStatus(string $user_id, string $status)
    {
        return $this->db->update('users', ['status' => $status], ['user_id' => $user_id]);
    }

    public function updaetToken(string $user_id, string $token)
    {
        return $this->db->update('users', ['token' => $token], ['user_id' => $user_id]);
    }

    public function changePassword(string $user_id, string $password)
    {
        return $this->db->update('users', ['password' => $password], ['user_id' => $user_id]);
    }

    public function addToCart(string $user_id, string $product_id): string
    {
        $result = $this->db->select('cart', ['user_id' => $user_id, 'product_id' => $product_id]);

        if ($result) {
            return  $this->updateCart($result[0]['cart_id'], $result[0]['quantity'] + 1);
        } else {
            $ret = $this->db->insert('cart', ['user_id' => $user_id, 'product_id' => $product_id]);
            if ($ret) {
                return "Done";
            }
        }

        return "Error";
    }

    public function removeFromCart(string $user_id, string $product_id): string
    {
        $result = $this->db->select('cart', ['user_id' => $user_id, 'product_id' => $product_id]);

        if ($result) {
            $ret = $this->db->delete('cart', ['cart_id' => $result[0]['cart_id']]);
            if ($ret) {
                return "Done";
            }
        }
        return "Error";
    }

    public function decreaseQuantity(string $cart_id): string
    {
        $result = $this->db->select('cart', ['cart_id' => $cart_id]);

        if ($result) {
            if ($result[0]['quantity'] > 1) {
                return  $this->updateCart($result[0]['cart_id'], $result[0]['quantity'] - 1);
            } else {
                $ret = $this->db->delete('cart', ['cart_id' => $result[0]['cart_id']]);
                if ($ret) {
                    return "Done";
                }
            }
        }
        return "Error";
    }
    public function increaseQuantity(string $cart_id): string
    {
        $result = $this->db->select('cart', ['cart_id' => $cart_id]);

        $productDetails = $this->db->select('products', ['product_id' => $result[0]['product_id']]);

        if ($productDetails[0]['stock'] - $result[0]['quantity'] > 0) {

            return  $this->updateCart($result[0]['cart_id'], $result[0]['quantity'] + 1);
        } else {
            return "Out Of Stock";
        }
        return "Error";
    }

    public function updateCart(string $cart_id, int $quantity): string
    {
        $result = $this->db->update('cart', ['quantity' => $quantity], ['cart_id' => $cart_id]);
        if ($result) {
            return "Done";
        } else {

            return "Error";
        }
    }

    public function cartItems(string $user_id): array|null
    {
        return $this->db->execute("SELECT * FROM cart JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = $user_id;");
    }

    public function addAddress(string $user_id, string $address): string
    {
        return $this->db->insert('address', ['user_id' => $user_id, 'address' => $address]);
    }

    public function getAddress(string $user_id)
    {
        return $this->db->select('address', ['user_id' => $user_id]);
    }
}
