<?php
/**
 * Created by PhpStorm.
 * User: marioskrlec
 * Date: 15/07/15
 * Time: 21:57
 */

namespace EntityFilter\Tests\CollectionCreator;


use Doctrine\Common\Collections\ArrayCollection;

class CollectionCreator
{
    public function create($namespace, $times)
    {
        $collection = new ArrayCollection();

        for ($i = 1; $i <= $times; $i++) {
            $object = new $namespace();

            $object->setId($i);

            $collection->add($object);
        }

        return $collection;
    }
}