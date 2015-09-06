<?php
/**
 * Created by PhpStorm.
 * User: marioskrlec
 * Date: 07/08/15
 * Time: 15:14
 */

namespace EntityFilter\Tests\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class ProductsBought
{
    private $id;

    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function addProduct(Product $product)
    {
        $this->products->add($product);
    }

    public function setProducts(ArrayCollection $products)
    {
        $this->products = $products;
    }

    public function getProducts()
    {
        return $this->products;
    }


}