<?php

namespace EntityFilter\Entity;

use EntityFilter\Config\ConfigHelper;
use EntityFilter\Config\Contracts\FilterConfigInterface;
use EntityFilter\Config\FilterCodes;
use EntityFilter\Debug\Debug;
use EntityFilter\Entity\Contract\EntityInterface;
use EntityFilter\Reflection\MethodExecutable;
use EntityFilter\Reflection\ObjectExecution;
use EntityFilter\Config\FilterConfig;
use EntityFilter\Entity\Entity;

class Entity implements EntityInterface
{
    private $entityObject;
    private $filterConfig;
    private $configName;
    private $codes;

    private $innerEntities = array();

    private $result = array();

    public function setEntity($entity)
    {
        $this->entityObject = $entity;

        return $this;
    }

    public function setCodes(FilterCodes $codes)
    {
        $this->codes = $codes;
    }

    public function setConfig(FilterConfigInterface $config)
    {
        $this->filterConfig = $config;

        $this->configName = $config->getCollectionName();

        $configHelper = new ConfigHelper($config);

        if (($parsedConfig = $configHelper->guessIsCollection()) !== null) {
            foreach($parsedConfig as $entityString => $methods) {
                $config = new FilterConfig();
                $config->setCollectionName($entityString)
                       ->setCollectionMethods($methods);

                $entity = new Entity();
                $entity->setEntity($entity)
                       ->setConfig($config);

                $this->innerEntities[] = $entity;
            }
        }

        return $this;
    }

    public function getEntity()
    {
        return $this->entityObject;
    }

    public function getConfig()
    {
        return $this->filterConfig;
    }

    public function getConfigName()
    {
        return $this->configName;
    }

    public function run()
    {
        $collectionMethods = $this->filterConfig->getCollectionMethods();
        $collectionName = $this->filterConfig->getCollectionName();

        $methodExecutable = new MethodExecutable($collectionMethods, $collectionName);

        $objectExecution = new ObjectExecution();
        $this->result = $objectExecution->runObject($this->entityObject, $methodExecutable);

        if ($this->codes->getCode('disable-multidimensional') === false) {
            foreach ($this->innerEntities as $entity) {
                if($entity instanceof Entity) {
                    $this->result->addResult($entity->run()->getResult());
                }
            }
        }

        return $this;
    }

    public function getResult()
    {
        return $this->result;
    }
}