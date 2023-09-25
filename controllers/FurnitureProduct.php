<?php

namespace Products\ProductController;

class FurnitureProduct extends MainProduct
{
    public $dimension;   // in (HxWxL)

    public function __construct($sku, $name, $price, $dimension)
    {
        parent::__construct($sku, $name, $price);
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

    public function getProductType()
    {
        return "furniture";
    }

    public function getDetails()
    {
        return "FurnitureProduct : Name - " . $this->getName() . ", Price - " . $this->getPrice() . ", Dimension - " . $this->getDimension();
    }

  
}