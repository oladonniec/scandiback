<?php

namespace ProductController;

class FurnitureProduct extends MainProduct
{
    public $dimension;   // in (HxWxL)

    public function __construct($sku, $product_type, $name, $price, $dimension)
    {
        parent::__construct($sku, $product_type, $name, $price);
        $this->dimension = $dimension;
    }

    public function getDimension()
    {
        return $this->dimension;
    }

    public function setDimension($dimension)
    {
        $this->dimension = $dimension;
    }

    public function getDetails()
    {
        return "FurnitureProduct : Name - " . $this->getName() . ", Price - " . $this->getPrice() . ", Dimension - " . $this->getDimension();
    }
}