<?php

namespace ProductController;

class BookProduct extends MainProduct
{
    public $weight;  //  in KG

    public function __construct($sku, $product_type, $name, $price, $weight)
    {
        parent::__construct($sku, $product_type, $name, $price);
        $this->weight = $weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getDetails()
    {
        return "BookProduct : Name - " . $this->getName() . ", Price - " . $this->getPrice() . ", Weight - " . $this->getWeight();
    }
}