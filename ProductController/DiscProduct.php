<?php

namespace ProductController;

class DiscProduct extends MainProduct
{
    public $size;    // in MB

    public function __construct($sku, $product_type, $name, $price, $size)
    {
        parent::__construct($sku, $product_type, $name, $price);
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getDetails()
    {
        return "DiscProduct : Name - " . $this->getName() . ", Price - " . $this->getPrice() . ", Size - " . $this->getSize();
    }
}