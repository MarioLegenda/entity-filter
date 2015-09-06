<?php

namespace EntityFilter\Debug;

class Debug
{
    private static $instance;

    private $watchers = array();

    public static function init()
    {
        self::$instance = (self::$instance) ? self::$instance : new self();

        return self::$instance;
    }

    public function name($name)
    {
        if (array_key_exists($name, $this->watchers)) {
            return $this->watchers[$name];
        }

        $watcher = new Watcher($name);

        $this->watchers[$name] = $watcher;

        return $this->watchers[$name];
    }

    public function debug($var)
    {
        echo "<pre>";
        var_dump($var);
        die();
    }
}