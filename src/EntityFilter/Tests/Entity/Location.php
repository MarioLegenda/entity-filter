<?php

namespace EntityFilter\Tests\Entity;

class Location
{
    private $id;
    private $latitude;
    private $longtitude;
    private $address;
    private $city;

    public function __construct()
    {
        $this->latitude = '12.34.56';
        $this->longtitude = '87.36.28';
        $this->address = 'Sunčana 24';
        $this->city = 'Split';
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLongtitude($longtitude)
    {
        $this->longtitude = $longtitude;
    }

    public function getLongtitude()
    {
        return $this->longtitude;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCity()
    {
        return $this->city;
    }
}