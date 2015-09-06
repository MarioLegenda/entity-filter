<?php

namespace EntityFilter\Reflection;

use EntityFilter\Iteration\GenericIterator;

class MethodExecutionResult implements \IteratorAggregate
{
    private $result = array();

    private $iterator;

    public function addResult(array $result)
    {
        $this->result[] = $result;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getIterator()
    {
        return ($this->iterator) ? $this->iterator : new GenericIterator($this->result);
    }

    public function getOffset($offset)
    {
        if($this->offsetExists($offset)) {
            return $this->result[$offset];
        }

        return null;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->result);
    }

}