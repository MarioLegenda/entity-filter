<?php

namespace EntityFilter\Config\Contracts;

interface FilterCodesInterface
{
    function isGeneral();
    function isSpecific();
    function getCode($code);
}