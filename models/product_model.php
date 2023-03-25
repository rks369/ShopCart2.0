<?php
require_once('services/db_config.php');

class Product
{
    public string $product_id;
    public string $title;
    public string $description;
    public int $price;
    public int $stock;
    public string $imageurl;
    public string $seller_id;
    public string $status;

    public function __construct(array $data)
    {

        $this->product_id = $data['product_id'] ?? '-1';
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->price = $data['price'] ?? 0;
        $this->stock = $data['stock'] ?? 0;
        $this->imageurl = $data['imageurl'] ?? '';
        $this->seller_id = $data['seller_id'] ?? '-1';
        $this->status = $data['status'] ?? '';
    }


    public function toArray()
    {
        $sellerDetails = [];

        $sellerDetails['title'] = $this->title;
        $sellerDetails['description'] = $this->description;
        $sellerDetails['price'] = $this->price;
        $sellerDetails['stock'] = $this->stock;
        $sellerDetails['status'] = $this->status;
        $sellerDetails['imageurl'] = $this->imageurl;
        $sellerDetails['seller_id'] = $this->seller_id;
        return $sellerDetails;
    }
}

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }
    function addProduct(array $details): string
    {
        return $this->db->insert('products', $details);
    }

    public function getProducts($current_index, $count): array
    {
        $productList = [];

        $sql_query = "SELECT * FROM products WHERE status=0 LIMIT $count OFFSET $current_index;";
        $result = $this->db->execute($sql_query);
        if ($result) {
            $productList = $result;
        }
        return $productList;
    }
    public function getSellerProducts($current_index, $count): array
    {
        $productList = [];
        $sql_query = "SELECT * FROM products WHERE seller_id = $_SESSION[id] LIMIT $count OFFSET$current_index;";
        $result = $this->db->execute($sql_query);
        if ($result) {
            $productList = $result;
        }
        return $productList;
    }
    public function getProduct($product_id): array
    {
        $productList = [];

        $result = $this->db->select('products', ['product_id' => $product_id]);
        if ($result) {
            $productList = $result;
        }
        return $productList;
    }
}
