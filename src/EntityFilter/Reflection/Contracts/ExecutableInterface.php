<?php

namespace EntityFilter\Reflection\Contracts;

interface ExecutableInterface
{
    function runMethods($object);
}