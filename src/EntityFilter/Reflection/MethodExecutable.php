<?php

namespace EntityFilter\Reflection;

use EntityFilter\Iteration\GenericIterator;
use EntityFilter\Reflection\Contracts\ExecutableInterface;

class MethodExecutable implements ExecutableInterface, \IteratorAggregate
{
    private $methods;
    private $collectionName;

    private $methodIterator = null;

    public function __construct(array $methods, $collectionName)
    {
        $this->methods = $methods;
        $this->collectionName = $collectionName;
    }

    public function runMethods($object)
    {
        $result = array();
        $collectionMethod = $this->resolveCollectionName($this->collectionName);
        $resolvedMethods = $this->resolveMethods($this->methods);

        $collection = $object->$collectionMethod();

        foreach ($collection as $collectionObject) {
            $temp = array();
            foreach ($resolvedMethods as $methodString) {
                $method = $resolvedMethods->notValidate()->resolve($methodString);
                $temp[$methodString] = $collectionObject->$method();
            }

            $result[] = $temp;
        }

        return $result;
    }

    public function getIterator()
    {
        return ($this->methodIterator) ? $this->methodIterator : new GenericIterator($this->methods);
    }

    private function resolveCollectionName($collectionName)
    {
        return 'get'.ucfirst($collectionName);
    }

    private function resolveMethods(array $methods)
    {
        return new ResolvedMethods($methods);
    }
}