<?php

namespace EntityFilter\Tests\Entity;

class Phone
{
    private $id;
    private $phone;

    public function __construct()
    {
        $this->phone = '0967483726';
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getPhone()
    {
        return $this->phone;
    }
}