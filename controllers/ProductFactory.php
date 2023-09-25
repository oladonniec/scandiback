<?php

namespace Products\ProductController;
use \Exception;

class ProductFactory {
    public static function createProduct($type, $sku, $name, $price, $size, $weight, $height, $width, $length){
        $dimension = $height . 'x' . $width . 'x' . $length;
        $lookup = [
            "disc" => ["data" => new DiscProduct($sku, $name, $price, $size)],
            "book" => ["data" => new BookProduct($sku, $name, $price, $weight)],
            "furniture" => ["data" => new FurnitureProduct($sku, $name, $price, $dimension)],
        ];
        if (!array_key_exists($type, $lookup)) {
            throw new Exception('Invalid product type.');
            return http_response_code(400);
            exit;
        }
        $lookupItem = $lookup[$type];
        return $lookupItem["data"];
    }
}