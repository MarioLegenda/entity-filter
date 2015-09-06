<?php

namespace EntityFilter\Config\Contracts;

interface FilterConfigInterface
{
    function setCollectionName($collName);
    function setCollectionMethods($collMethods);
    function getCollectionName();
    function getCollectionMethods();
}