<?php


namespace EntityFilter\Tests\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class User
{
    private $id;
    private $name;
    private $lastname;

    private $phones;
    private $locations;
    private $productsBought;

    public function __construct()
    {
        $this->phones = new ArrayCollection();
        $this->locations = new ArrayCollection();
        $this->productsBought = new ArrayCollection();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }




    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }




    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }




    public function addPhone(Phone $phone)
    {
        $this->phones->add($phone);
    }

    public function removePhone(Phone $phone)
    {
        $this->phones->removeElement($phone);
    }

    public function getPhones()
    {
        return $this->phones;
    }



    public function addLocation(Location $location)
    {
        $this->locations->add($location);
    }

    public function removeLocation(Location $location)
    {
        $this->locations->removeElement($location);
    }

    public function getLocations()
    {
        return $this->locations;
    }



    public function setProductsBought(ArrayCollection $productsBought)
    {
        $this->productsBought = $productsBought;
    }

    public function addProductsBought(ProductsBought $productBought)
    {
        $this->productsBought->add($productBought);
    }

    public function removeProductsBought(ProductsBought $productBought)
    {
        $this->productsBought->removeElement($productBought);
    }

    public function getProductsBought()
    {
        return $this->productsBought;
    }
}