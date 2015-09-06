<?php

namespace EntityFilter\Config;

use EntityFilter\Config\Contracts\FilterConfigInterface;
use EntityFilter\Exception\EntityFilterException;
use EntityFilter\Iteration\GenericIterator;

class FilterConfig implements FilterConfigInterface, \IteratorAggregate
{
    private $collectionName;
    private $collectionMethods = array();

    private $methodIterator = null;

    public function __construct(array $config = null)
    {
        if ($config) {
            $keys = array_keys($config);

            $this->collectionName = $keys[0];
            $this->collectionMethods = $config[$keys[0]];
        }
    }

    public function setCollectionName($collName)
    {
        if (!is_string($collName)) {
            throw new EntityFilterException('FilterConfig::setCollectionName() has to receive a string');
        }

        $this->collectionName = $collName;

        return $this;
    }

    public function getCollectionName()
    {
        return $this->collectionName;
    }

    public function setCollectionMethods($collMethods)
    {
        $this->collectionMethods = $collMethods;

        return $this;
    }

    public function getCollectionMethods()
    {
        return $this->collectionMethods;
    }

    public function getIterator()
    {
        return ($this->methodIterator) ? $this->methodIterator : new GenericIterator($this->collectionMethods);
    }

    public function asArray()
    {
        return array($this->collectionName => $this->collectionMethods);
    }
}