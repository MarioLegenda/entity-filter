<?php

namespace EntityFilter\Exception;

class ConfigException extends AbstractException
{
    /**
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}