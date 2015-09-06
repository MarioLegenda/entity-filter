<?php

namespace EntityFilter;

use EntityFilter\Config\FilterCodes;
use EntityFilter\Config\FilterConfig;
use EntityFilter\Entity\Entity;
use EntityFilter\Entity\EntityIterator;
use EntityFilter\Exception\EntityFilterException;


class EntityFilter
{
    private $config = array();
    private $entityIterator = null;
    private $entity = null;
    private $var = 'data';

    private $invalidConfig = false;

    /**
     * @param array $config
     * @return $this
     * @throws EntityFilterException
     *
     * Creates a EntityIterator that has a collection of Entity objects. Entity object has its own FilterConfig
     * object and FilterConfig object has the configuration for a given collection.
     *
     * For example,
     * array(
            'location' => array('id', 'longtitude'),
     *      'phone' => array('id', 'phone', 'name'),
     * )
     *
     * One Entity object will be created (with its own FilterConfig) for every entry in this example array.
     * That Entity object will be added to EntityIterator.
     */
    public function configure(array $config)
    {
        if($this->entity === null) {
            throw new EntityFilterException('EntityFilter::configure() -> setEntity() method has to be called before configure()');
        }

        /**
         * If $config is an empty array, then $this::$invalidConfig is false. In that case, $this::getFiltered()
         * will return all the results specified by $config
         */
        if (empty($config)) {
            $this->invalidConfig = true;

            return $this;
        }

        $this->config = $config;

        $eIt = new EntityIterator();

        foreach($config as $configKey => $configValueArray) {
            $config = new FilterConfig();
            $config->setCollectionName($configKey)
                   ->setCollectionMethods($configValueArray);

            $entity = new Entity();
            $entity->setEntity($this->entity)
                   ->setConfig($config);

            $eIt->addEntity($entity);
        }

        $this->entityIterator = $eIt;

        return $this;
    }

    public function setDataVar($var)
    {
        $this->var = $var;

        return $this;
    }

    public function setEntity($entity)
    {
        if (!$entity) {
            throw new EntityFilterException('setEntity() -> Entity has to be an object');
        }

        $this->entity = $entity;

        return $this;
    }

    public function getFiltered($entityKey = 'all')
    {
        if ($this->invalidConfig) {
            return $this->entity;
        }

        $codes = new FilterCodes($entityKey);
        $codes->setCode('disable-multidimensional', true);

        $result = $this->entityIterator->run($codes);

        return array($this->var => $result);
    }
}