<?php

namespace EntityFilter\Debug;

class Watcher
{
    private $name;

    private $times = 0;
    private $current = 0;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function times($times)
    {
        $this->times = $times;

        return $this;
    }

    public function debug($var)
    {
        if ($this->current === $this->times) {
            echo "<pre>";
            var_dump($var);
            die();
        }

        $this->current++;
    }
}