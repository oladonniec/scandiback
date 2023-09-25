<?php

namespace Products\ProductController;

use \PDO;
use \PDOException;

use Products\ProductController\DiscProduct;
use Products\ProductController\BookProduct;
use Products\ProductController\FurnitureProduct;
use Products\ProductController\ProductFactory;

class Controller {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addProduct($product)
    {
        $product = ProductFactory::createProduct($product["product_type"], $product["sku"], $product["name"], $product["price"], $product["size"] ?? "", $product["weight"] ?? "", $product["height"] ?? "", $product["width"] ?? "", $product["length"] ?? "");
        try {
            $query = "INSERT INTO products (sku, product_type, name, price, size, weight, dimension) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->conn->prepare($query);
            var_dump("Query Done");
            $stmt->execute([
                $product->getSku(), // sku - unique key
                $product->getProductType(),
                $product->getName(),
                $product->getPrice(),
                $product instanceof DiscProduct ? $product->getSize() : "",
                $product instanceof BookProduct ? $product->getWeight() : "",
                $product instanceof FurnitureProduct ? $product->getDimension() : ""
            ]);
            var_dump("Got here 4");
            return json_encode(["status" => "success", "message" => 'Product added successfully']);
        } catch (PDOException $e) {
            var_dump("Got to error here");
            return json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function getAllProducts()
    {
        try {
            $query = "SELECT * FROM products";
            $stmt = $this->db->conn->query($query);
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
        try {
            $products = implode(',', array_fill(0, count($product_ids), '?'));
            $query = "SELECT COUNT(sku) as count FROM products WHERE sku IN ($products)";
            $stmt = $this->db->conn->prepare($query);
            $stmt->execute($product_ids);
            $result = $stmt->fetch();
            if (!$result['count']) {
                return json_encode(["status" => "error", "message" => 'No products found']);
            }
            $query = "DELETE FROM products WHERE sku IN ($products)";
            $stmt = $this->db->conn->prepare($query);
            $stmt->execute($product_ids);
            return json_encode(["status" => "success", "message" => 'Product deleted successfully']);
        } catch (PDOException $e) {
            return json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}