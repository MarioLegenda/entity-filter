<?php

namespace EntityFilter\Config;

use EntityFilter\Config\Contracts\FilterCodesInterface;
use EntityFilter\Exception\EntityFilterException;

class FilterCodes implements FilterCodesInterface
{
    private $code = 'all';

    private $assocCodes = array();

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function isGeneral()
    {
        return ($this->code === 'all') ? true : false;
    }

    public function isSpecific()
    {
        return ($this->code !== 'all') ? true : false;
    }

    public function getCode($code)
    {
        if (!array_key_exists($code, $this->assocCodes)) {
            throw new EntityFilterException('FilterCodes::getCode($code): '.$code.' does not exist');
        }

        return $this->assocCodes[$code];
    }

    public function setCode($code, $value)
    {
        if (!is_bool($value)) {
            throw new EntityFilterException('FilterCodes::setCode($code, $value): $value should be a boolean');
        }

        $this->assocCodes[$code] = $value;
    }
}