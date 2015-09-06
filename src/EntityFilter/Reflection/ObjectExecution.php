<?php

namespace EntityFilter\Reflection;

use EntityFilter\Reflection\Contracts\ExecutableInterface;

class ObjectExecution
{
    public function runObject($object, ExecutableInterface $executable)
    {
        $methodExecutionResult = new MethodExecutionResult();

        $result = $executable->runMethods($object);

        $methodExecutionResult->addResult($result);

        return $methodExecutionResult;
    }
}