<?php

namespace EntityFilter\Tests;

use EntityFilter\Config\ConfigHelper;
use EntityFilter\Config\FilterConfig;
use EntityFilter\Entity\Entity;
use EntityFilter\Entity\EntityIterator;
use EntityFilter\EntityFilter;
use EntityFilter\Tests\CollectionCreator\CollectionCreator;
use EntityFilter\Tests\Entity\ProductsBought;
use EntityFilter\Tests\Entity\User;
use EntityFilter\Tests\EntityFiller\Filler;

class SingleEntityFilterTest extends \PHPUnit_Framework_TestCase
{
    private $user;

    public function __construct()
    {
        $cc = new CollectionCreator();
        $locationCollection = $cc->create('EntityFilter\Tests\Entity\Location', 10);
        $productCollection = $cc->create('EntityFilter\Tests\Entity\Product', 10);
        $phoneCollection = $cc->create('EntityFilter\Tests\Entity\Phone', 10);

        $filler = new Filler();
        $user = $filler
            ->setRoot(new User())
            ->addToCollection('addLocation', $locationCollection)
            ->addToCollection('addPhone', $phoneCollection)
            ->getRoot();

        $productsBought = $filler
            ->setRoot(new ProductsBought())
            ->addToCollection('addProduct', $productCollection)
            ->getRoot();

        $user->addProductsBought($productsBought);

        $this->user = $user;
    }

    public function testFilterConfig()
    {
        $config = array(
            'locations' => array('id', 'latitude'),
            'phones' => array('id', 'phone'),
        );

        $filterConfig = new FilterConfig($config);
    }

    public function testConfigHelper()
    {
        $config = array(
            'locations' => array('id', 'latitude'),
        );

        foreach ($config as $key => $c) {
            $configHelper = new ConfigHelper(new FilterConfig(array($key => $c)));

            $this->assertTrue($configHelper->configExists('locations'), 'testConfigHelper() --> locations config key does not exist');

            $locationsConfig = $configHelper->getConfig('locations');

            $expectedKeys = array('found', 'searched', 'find-result', 'compact-result');

            foreach ($expectedKeys as $exp) {
                $this->assertArrayHasKey($exp, $locationsConfig, 'testConfigHelper() --> '.$exp.' key not found in $locationsConfig');
            }

            $this->assertTrue($locationsConfig['found'], 'testConfigHelper() --> $locationsConfig[\'found\'] should be true');
            $this->assertEquals($locationsConfig['searched'], 'locations', 'testConfigHelper() --> $locationsConfig[\'searched\'] should contain a $configKey string');
            $this->assertInternalType('array', $locationsConfig['find-result'], 'testConfigHelper() --> $locationsConfig[\'find-result\'] should contain a $configKey string');

            $findResult = $locationsConfig['find-result'];

            $this->assertEquals($findResult['key'], 'locations', 'testConfigHelper() --> $locationsConfig[\'find-result\'][\'key\'] should contain a $configKey string');
            $this->assertInternalType('array', $findResult['value'], 'testConfigHelper() --> $locationsConfig[\'find-result\'][\'value\'] should be an array');
        }

    }

    public function testEntityIterator()
    {
        $config = array(
            'locations' => array('id', 'latitude'),
            'phones' => array('id', 'phone'),
        );

        $eIt = new EntityIterator();

        foreach($config as $configKey => $configValueArray) {
            $config = new FilterConfig();
            $config->setCollectionName($configKey)
                ->setCollectionMethods($configValueArray);

            $entity = new Entity();
            $entity->setEntity($this->user)
                ->setConfig($config);

            $eIt->addEntity($entity);
        }

        $this->assertInternalType('array', $eIt->getEntities(), 'testEntityIterator(): --> EntityIterator::getEntities() has to return an array');
        $this->assertInstanceOf('EntityFilter\Entity\Entity', $eIt->getEntity('locations'), 'testEntityIterator(): --> EntityIterator::getEntity($key) has to return an Entity object');
        $this->assertTrue($eIt->entityExists('locations'), 'testEntityIterator(): --> EntityIterator::entityExists() has to be true with parameter locations');
        $this->assertFalse($eIt->entityExists('not-exists'), 'testEntityIterator(): --> EntityIterator::entityExists() has to return false with parameter not-exists');

        foreach($eIt as $e) {
            $this->assertInternalType('object', $e->getEntity(), 'testEntityIterator(): --> Entity::getEntity() should return an object');
            $this->assertInstanceOf('EntityFilter\Config\Contracts\FilterConfigInterface', $e->getConfig(), 'testEntityIterator(): --> Entity::getConfig() should return FilterConfigInterface');
            $this->assertInternalType('string', $e->getConfigName(), 'testEntityIterator(): --> Entity::getConfigName() should return a string');
        }
    }

    public function testEmptyConfiguration()
    {
        $entityFilter = new EntityFilter();

        $filtered = $entityFilter
            ->setEntity($this->user)
            ->configure(array(
                'locations' => array('id', 'longtitude', 'latitude'),
                'phones' => array('id', 'phone')
            ))
            ->setDataVar('user')
            ->getFiltered();
    }
}