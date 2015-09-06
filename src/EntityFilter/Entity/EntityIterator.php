<?php

namespace EntityFilter\Entity;

use EntityFilter\Config\Contracts\FilterCodesInterface;
use EntityFilter\Entity\Contract\EntityInterface;
use EntityFilter\Entity\Contract\EntityIteratorInterface;

class EntityIterator implements \Iterator, \Countable, EntityIteratorInterface
{
    private $entities = array();
    private $length = 0;

    private $result = array();

    public function addEntity(EntityInterface $entity)
    {
        $this->entities[$entity->getConfigName()] = $entity;
    }

    public function getEntities()
    {
        if(!$this->entityExists()) {
            return null;
        }

        return $this->entities;
    }

    public function getEntity($key)
    {
        if (!$this->entityExists($key)) {
            return null;
        }

        return $this->entities[$key];
    }

    public function entityExists($entityKey = null)
    {
        if (empty($this->entities)) {
            return null;
        }

        if ($entityKey === null) {
            return true;
        }

        return array_key_exists($entityKey, $this->entities);
    }

    public function run(FilterCodesInterface $codes)
    {
        foreach ($this->entities as $entityName => $entity) {
            $entity->setCodes($codes);
            $this->result[$entityName] = $entity->run()->getResult();
        }

        return $this->result;
    }

    public function current()
    {
        if ($this->valid()) {
            return $this->entities[$this->length];
        }
    }

    public function valid()
    {
        return array_key_exists($this->length, $this->entities);
    }

    public function next()
    {
        ++$this->length;

        return $this->entities[$this->length];
    }

    public function key()
    {
        return $this->length;
    }

    public function rewind()
    {
        return $this->length = 0;
    }

    public function count()
    {
        return count($this->entities);
    }

    public function getIterator()
    {
        return $this->entities;
    }
}