<?php

namespace Products\ProductController;

class BookProduct extends MainProduct
{
    public $weight;  //  in KG

    public function __construct($sku, $name, $price, $weight)
    {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getProductType(){
        return "book";
    }

    public function getDetails()
    {
        return "BookProduct : Name - " . $this->getName() . ", Price - " . $this->getPrice() . ", Weight - " . $this->getWeight();
    }
}