<?php

declare(strict_types=1);

namespace Validator;

class ProductValidator
{
    public function validateProductToDelete($product)
    {
        if (!isset($product['skus'])) {
            throw new \Exception("The product id is required");
        }
    }

    public function validateProduct(array $product): void
    {
        if (!isset($product['product_type'])) {
            throw new \Exception("The product type is required");
        }
        $requiredFields = [
            'product_type' => 'The product type is required',
            'name' => 'Name is required and must be a string',
            'price' => 'Price is required and must be an integer',
        ];

        $validations = [
            'name' => 'validateString',
            'price' => 'validateInteger',
        ];

        $errorMessage = [];

        //check required fields
        foreach ($requiredFields as $field => $message) {
            if (!isset($product[$field])) {
                array_push($errorMessage, $message);
            }
        }

        //check validations
        switch ($product['product_type']) {
            case "disc":
                if (!isset($product['size'])) {
                    array_push($errorMessage, "Size is required and must be an integer");
                }
                $validations['size'] = 'validateInteger';
                break;
            case "book":
                if (!isset($product['weight'])) {
                    var_dump("hello there");
                    array_push($errorMessage, "Weight is required and must be an integer");
                }
                $validations['weight'] = 'validateInteger';
                break;
            case "furniture":
                if (!isset($product['height'])) {
                    array_push($errorMessage, "Height is required and must be an integer");
                }
                if (!isset($product['width'])) {
                    array_push($errorMessage, "Width is required and must be an integer");
                }
                if (!isset($product['length'])) {
                    array_push($errorMessage, "Length is required and must be an integer");
                }
                $validations['height'] = 'validateInteger';
                $validations['width'] = 'validateInteger';
                $validations['length'] = 'validateInteger';
                break;
            default:
                array_push($errorMessage, "Invalid product type.");
                break;
        }

        // check if there is any error
        if (!empty($errorMessage)) {
            throw new \Exception(implode(", ", $errorMessage));
        }
        // check data type
        foreach ($validations as $field => $method) {
            if (!$this->$method($product[$field])) {
                array_push($errorMessage, $requiredFields[$field]);
            }
        }
    }

    private function validateString($value)
    {
        return is_string($value) && !empty($value);
    }

    private function validateInteger($value)
    {
        return is_numeric($value) && intval($value) == $value && !empty($value);
    }
}