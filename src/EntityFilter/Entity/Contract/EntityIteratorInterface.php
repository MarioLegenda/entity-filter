<?php

namespace EntityFilter\Entity\Contract;

use EntityFilter\Config\Contracts\FilterCodesInterface;

interface EntityIteratorInterface
{
    function addEntity(EntityInterface $entity);
    function getEntities();
    function getEntity($key);
    function entityExists($key = null);
    function run(FilterCodesInterface $codes);
}