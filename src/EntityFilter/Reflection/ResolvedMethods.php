<?php

namespace EntityFilter\Reflection;

use EntityFilter\Exception\EntityFilterException;
use EntityFilter\Iteration\GenericIterator;

class ResolvedMethods implements \IteratorAggregate
{
    private $methods;

    private $validationObject = null;
    private $validation = false;

    private $iterator;

    public function __construct(array $methods)
    {
        $this->methods = $methods;
    }

    public function doValidate($object)
    {
        $this->validationObject = $object;
        $this->validation = true;

        return $this;
    }

    public function notValidate()
    {
        $this->validation = false;

        return $this;
    }

    public function resolve($method)
    {
        if ($this->validation) {

            if (!is_object($this->validationObject)) {
                return $this;
            }

            if (!method_exists($this->validationObject, $method)) {
                throw new EntityFilterException(get_class($this->validationObject).' does not have a method named '.$method);
            }

            return $this;
        }

        return 'get'.ucfirst($method);
    }

    public function getIterator()
    {
        return ($this->iterator) ? $this->iterator : new GenericIterator($this->methods);
    }
}