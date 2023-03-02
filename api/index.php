<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: http://localhost:3000');
header("Access-Control-Allow-Methods: GET, POST, DELETE");
require '../config/Database.php';
require '../Validator/validator.php';
require '../ProductController/MainProduct.php';
require '../ProductController/DiscProduct.php';
require '../ProductController/BookProduct.php';
require '../ProductController/FurnitureProduct.php';

use ProductController\BookProduct;
use ProductController\DiscProduct;
use ProductController\FurnitureProduct;
use Validator\ProductValidator;



$request_method = $_SERVER['REQUEST_METHOD'];

var_dump($request_method);

$allowed_methods = ['GET', 'POST', 'DELETE'];

if (!in_array($request_method, $allowed_methods)) {
var_dump("This is the error here");
    return http_response_code(405);
    exit;
}

switch($request_method){
    case "GET":
        $db = new DBConnection();
        echo $db->getAllProducts();
    break;
    case "POST":
        $productValidator = new ProductValidator();
        try {
        $productValidator->validateProduct($_POST);
        } catch (Exception $e) {
        var_dump("hello here");
        exit(json_encode(["status" => "error", "message" => $e->getMessage()]));
        }
        $db = new DBConnection();
        switch ($_POST['product_type']) {
            case 'disc':
                $discProduct = new DiscProduct($_POST['sku'], $_POST['product_type'], $_POST['name'], $_POST['price'], $_POST['size']);
                echo $db->addProduct($discProduct);
                break;
            case 'book':
                $bookProduct = new BookProduct($_POST['sku'], $_POST['product_type'],  $_POST['name'], $_POST['price'], $_POST['weight']);
                echo $db->addProduct($bookProduct);
                break;
            case 'furniture':
                    $dimension = $_POST['height'] . 'x' . $_POST['width'] . 'x' . $_POST['length'];
                    $furnitureProduct = new FurnitureProduct($_POST['sku'], $_POST['product_type'],  $_POST['name'], $_POST['price'], $dimension);
                    echo $db->addProduct($furnitureProduct);
                    break;
            default:
                echo 'invalid product type';
                break;
        }
    break;
    case "DELETE":
        var_dump("Delete Got to PHP");
        $productValidator = new ProductValidator();
        try {
            $productValidator->validateProductToDelete($_DELETE);
        } catch (Exception $e) {
            var_dump("The error came here");
            exit(json_encode(["status" => "error", "message" => $e->getMessage()]));
        }
                $db = new DBConnection();
                $product_ids = explode(",", $_POST['skus']);
                echo $db->massDeleteProducts($product_ids);
            break;
}