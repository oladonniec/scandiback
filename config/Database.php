<?php

use ProductController\BookProduct;
use ProductController\DiscProduct;
use ProductController\FurnitureProduct;

    class DBConnection {

        private $host = 'localhost';
        private $db_name = 'scandiweb';
        private $username = 'root';
        private $password = '';
        private $conn;

        public function __construct()
        {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host='. $this->host . ';dbname='. $this->db_name .';', $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $err) {
            echo 'Connection Error: '. $err->getMessage();
        }
        return $this->conn;

    }

    public function addProduct($product)
    {
        try {
            $query = "INSERT INTO products (sku, product_type, name, price, size, weight, dimension) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                $product->getSku(), // sku - unique key
                $product->getName(),
                $product->getPrice(),
                $product->getProductType(),
                $product instanceof DiscProduct ? $product->getSize() : "",
                $product instanceof BookProduct ? $product->getWeight() : "",
                $product instanceof FurnitureProduct ? $product->getDimension() : ""
            ]);
            return json_encode(["status" => "success", "message" => 'Product added successfully']);
        } catch (PDOException $e) {
            return json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function getAllProducts()
    {
        try {
            $query = "SELECT * FROM products";
            $stmt = $this->conn->query($query);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $filteredProducts = array_map(function ($product) {
                return array_filter($product, function ($value) {
                    return $value !== null;
                });
            }, $products);

            return json_encode(["status" => "success", "products" => $filteredProducts]);
        } catch (PDOException $e) {
            return json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function massDeleteProducts($product_ids)
    {
        var_dump(gettype($product_ids));
        var_dump($product_ids);
        try {
            $products = implode(',', array_fill(0, count($product_ids), '?'));
            $query = "SELECT COUNT(sku) as count FROM products WHERE sku IN ($products)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute($product_ids);
            $result = $stmt->fetch();
            if (!$result['count']) {
                return json_encode(["status" => "error", "message" => 'No products found']);
            }
            $query = "DELETE FROM products WHERE sku IN ($products)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute($product_ids);
            return json_encode(["status" => "success", "message" => 'Product deleted successfully']);
        } catch (PDOException $e) {
            return json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }
    }
