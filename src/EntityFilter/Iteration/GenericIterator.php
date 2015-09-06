<?php

namespace EntityFilter\Iteration;


use Doctrine\Common\Proxy\Exception\OutOfBoundsException;

class GenericIterator implements \Iterator
{
    private $length;
    private $iterator;

    public function __construct($iterator)
    {
        if (!is_array($iterator) AND !$iterator instanceof \Traversable) {
            throw new \UnexpectedValueException('GenericIterator: GenericIterator has to be constructed with a traversable data type');
        }

        $this->iterator = $iterator;
    }

    public function current()
    {
        if ($this->valid()) {
            return $this->iterator[$this->length];
        }

        throw new OutOfBoundsException('GenericIterator: current() is out of bounds');
    }

    public function next()
    {
        $this->length += 1;
    }

    public function valid()
    {
        return array_key_exists($this->length, $this->iterator);
    }

    public function key()
    {
        return $this->length;
    }

    public function rewind()
    {
        $this->length = 0;
    }
}