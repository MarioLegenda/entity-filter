<?php

namespace EntityFilter\Config;
use EntityFilter\Config\Contracts\FilterConfigInterface;
use EntityFilter\Debug\Debug;
use EntityFilter\Exception\EntityFilterException;

/**
 * Class ConfigHelper
 * @package EntityFilter\Config
 *
 *
 */
class ConfigHelper implements \IteratorAggregate
{
    private $configIterator;
    private $config;

    private $existsResult = array();

    public function __construct(FilterConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @param $configKey
     * @return bool
     *
     * If this method is called before getConfig(), then found $config is saved to $this::existsResult array.
     * If getConfig() is called after configExists() with the same $configKey, then $this::existsResult is
     * consulted.
     */
    public function configExists($configKey)
    {
        $config = $this->find($configKey, true);

        if ($config === null) {
            return false;
        }

        $result =  array(
            'found' => true,
            'searched' => $configKey,
            'find-result' => $config,
            'compact-result' => array($config['key'] => $config['value'])
        );

        $this->existsResult[$configKey] = $result;

        return true;
    }

    public function getConfig($key)
    {
        if (!$this->configExists($key)) {
            return null;
        }

        return $this->existsResult[$key];
    }

    public function clear($key = null)
    {
        if($key === null) {
            $this->existsResult = array();

            return true;
        }

        if (!array_key_exists($key, $this->existsResult)) {
            return false;
        }

        unset($this->existsResult[$key]);

        return true;
    }

    public function guessIsCollection()
    {
        $methods = $this->config->getCollectionMethods();

        $possibleCollections = array_keys($methods);

        //Debug::init()->name('quess-collection')->times(0)->debug($possibleCollections);

        if (!empty($possibleCollections) AND is_string($possibleCollections[0])) {
             foreach ($possibleCollections as $entity) {
                 if (!is_string($entity)) {
                     return null;
                 }
             }
        }

        return null;
    }

    public function getIterator()
    {
        if ($this->configIterator instanceof \RecursiveIteratorIterator) {
            return $this->configIterator;
        }

        $this->configIterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->config->asArray()), \RecursiveIteratorIterator::SELF_FIRST);

        return $this->configIterator;
    }

    private function find($configKey, $checkFilterConfig = false)
    {
        if ($configKey === $this->config->getCollectionName()) {
            return array(
                'key' => $configKey,
                'value' => $this->config->getCollectionMethods(),
                'depth' => null,
            );
        }

        foreach($this->config as $key => $configValue) {
            if($key === $configKey) {
                return array(
                    'key' => $key,
                    'value' => $configValue,
                    'depth' => $this->configIterator->getDepth()
                );
            }
        }

        return null;
    }
}