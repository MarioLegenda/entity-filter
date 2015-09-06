<?php
/**
 * Created by PhpStorm.
 * User: marioskrlec
 * Date: 15/07/15
 * Time: 21:44
 */

namespace EntityFilter\Tests\Exception;


class GenericTestException extends \Exception
{
    public function __construct($message)
    {
        $this->message = $message;
    }
}