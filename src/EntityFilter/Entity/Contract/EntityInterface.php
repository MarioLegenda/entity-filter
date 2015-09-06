<?php

namespace EntityFilter\Entity\Contract;


use EntityFilter\Config\Contracts\FilterConfigInterface;
use EntityFilter\Config\FilterCodes;

interface EntityInterface
{
    function setEntity($entity);
    function setConfig(FilterConfigInterface $config);
    function getEntity();
    function getConfig();
    function getConfigName();
    function setCodes(FilterCodes $codes);
    function run();
    function getResult();
}