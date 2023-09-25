<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Referrer-Policy: no-referrer");
header("Access-Control-Allow-Headers: Content-Type, Accept, Authorization, Origin, X-Api-Key, X-Requested-With");
header('HTTP/1.1 200 OK');

require_once __DIR__ . '/vendor/autoload.php';


use Configurations\DBConfig\Database;
use Products\ProductController\Controller;
use Validator\Validate\CheckValid as ProductValidator;


$request_method = $_SERVER['REQUEST_METHOD'];

$allowed_methods = ['GET', 'POST', 'DELETE', 'OPTIONS'];

if (!in_array($request_method, $allowed_methods)) {
    return http_response_code(405);
    exit;
}

switch($request_method){
    case "GET":
        $db = new Database();
        $prcontrol = new Products\ProductController\Controller($db);
        echo $prcontrol->getAllProducts();
    break;
    case "POST":
        $productValidator = new ProductValidator();
        try {
        $productValidator->validateProduct($_POST);
        } catch (Exception $e) {
        exit(json_encode(["status" => "error", "message" => $e->getMessage()]));
        }
        $db = new Database();
        $prcontrol = new Controller($db);
        $prcontrol->addProduct($_POST);
    break;
    case "DELETE":
        $productValidator = new ProductValidator();
        $payload = json_decode(file_get_contents("php://input"), true);
        try {
            $productValidator->validateProductToDelete($payload);
        } catch (Exception $e) {
            var_dump("The error came here");
            exit(json_encode(["status" => "error", "message" => $e->getMessage()]));
        }
        $db = new Database();
        $product_ids = $payload['skus'];
        $prcontroll = new Controller($db);
        echo $prcontroll->massDeleteProducts($product_ids);
        break;
}