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

class MultipleEntityFilterTest extends \PHPUnit_Framework_TestCase
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


    public function testConfigHelper()
    {
        $config = array(
            'productsBought' => array(
                'products' => array('id', 'name')
            )
        );

        $configHelper = new ConfigHelper(new FilterConfig($config));
    }


    public function testConfiguration()
    {
        $config = array(
            'productsBought' => array(
                'products' => array('id', 'name'),
            ),
        );

        $eIt = new EntityIterator();

        foreach($config as $configKey => $configValueArray) {
            $config = new FilterConfig();
            $config->setCollectionName($configKey)
                   ->setCollectionMethods($configValueArray);

            $entity = new Entity();
            $entity->setEntity($entity)
                   ->setConfig($config);

            $eIt->addEntity($entity);
        }
    }

    public function testEntityFilter()
    {
        $entityFilter = new EntityFilter();

        $filtered = $entityFilter
            ->setEntity($this->user)
            ->configure(array(
                'productsBought' => array(
                    'product' => array('id', 'name')
                )
            ))
            ->setDataVar('user')
            ->getFiltered();

        echo "<pre>";
        var_dump($filtered);
        die();
    }
}