<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
require '../config/Database.php';
require '../Validator/validator.php';


use Validator\ProductValidator;

$allowed_methods = ['POST'];
$request_method = $_SERVER['REQUEST_METHOD'];

if (!in_array($request_method, $allowed_methods)) {
    return http_response_code(405);
    exit;
}

$productValidator = new ProductValidator();
try {
    $productValidator->validateProductToDelete($_POST);
} catch (Exception $e) {
    var_dump("The error came here");
    exit(json_encode(["status" => "error", "message" => $e->getMessage()]));
}
$db = new DBConnection();
$product_ids = explode(",", $_POST['skus']);
echo $db->massDeleteProducts($product_ids);