<?php

namespace EntityFilter\Exception;

class EntityFilterException extends AbstractException
{
    /**
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}