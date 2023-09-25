<?php

namespace Products\ProductController;

class DiscProduct extends MainProduct
{
    public $size;    // in MB

    public function __construct($sku, $name, $price, $size)
    {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getProductType(){
        return "disc";
    }

    public function getDetails()
    {
        return "DiscProduct : Name - " . $this->getName() . ", Price - " . $this->getPrice() . ", Size - " . $this->getSize();
    }
}