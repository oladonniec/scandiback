<?php

namespace Products\ProductController;

interface ProductInterFace {
public function getName();
public function getPrice();
public function getSku();
}


abstract class MainProduct implements ProductInterFace
{
    private $sku;
    private $name;
    private $price;   // in $
    

    public function __construct($sku, $name, $price)
    {
        $this->name = $name;
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


    abstract public function getProductType();
    
}

