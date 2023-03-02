<?php

namespace ProductController;


abstract class MainProduct
{
    private $sku;
    private $product_type;
    private $name;
    private $price;   // in $
    

    public function __construct($sku, $name, $price, $product_type)
    {
        $this->name = $name;
        $this->product_type = $product_type;
        $this->price = $price;
        $this->sku = $sku . rand(100000, 999999); // unique key
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }
    public function getSku()
    {
        return $this->sku;
    }

    public function getProductType()
    {
        return $this->product_type;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    abstract public function getDetails();
}

