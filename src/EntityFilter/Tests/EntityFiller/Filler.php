<?php

namespace EntityFilter\Tests\EntityFiller;

use Doctrine\Common\Collections\ArrayCollection;
use EntityFilter\Tests\Exception\GenericTestException;

class Filler
{
    private $rootEntity;

    // root entity that is going to be filled with objects.
    // it is meant to be used when there is a 'add' method on
    // the root entity that is saved in an ArrayCollection
    public function setRoot($rootEntity)
    {
        $this->rootEntity = $rootEntity;

        return $this;
    }

    public function addToCollection($methodName, $entity)
    {
        if ($entity instanceof ArrayCollection) {
            foreach ($entity as $item) {
                $this->rootEntity->$methodName($item);
            }

            return $this;
        }

        $this->rootEntity->$methodName($entity);

        return $this;
    }

    public function getRoot()
    {
        return $this->rootEntity;
    }
}