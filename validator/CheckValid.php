<?php

declare(strict_types=1);

namespace Validator\Validate;

class CheckValid
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
        $validationRules = array(
            "disc" => array(
                "required_fields" => array("size"),
                "validations" => array(
                    "size" => "validateInteger"
                )
            ),
            "book" => array(
                "required_fields" => array("weight"),
                "validations" => array(
                    "weight" => "validateInteger"
                )
            ),
            "furniture" => array(
                "required_fields" => array("height", "width", "length"),
                "validations" => array(
                    "height" => "validateInteger",
                    "width" => "validateInteger",
                    "length" => "validateInteger"
                )
            )
        );
        
        $productType = $product['product_type'];
        
        if (isset($validationRules[$productType])) {
            $requiredFields = $validationRules[$productType]['required_fields'];
            $validations = $validationRules[$productType]['validations'];
        
            foreach ($requiredFields as $field) {
                if (!isset($product[$field])) {
                    array_push($errorMessage, ucfirst($field) . " is required and must be an integer");
                }
            }
        
            foreach ($validations as $field => $validation) {
                $validations[$field] = $validation;
            }
        } else {
            array_push($errorMessage, "Invalid product type.");
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