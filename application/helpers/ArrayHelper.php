<?php

class ArrayHelper
{
    public function toArray($val)
    {
        return array($val);
    }

    public function isArray($val)
    {
        if (!is_array($val)) return false;

        return true;
    }

    public function isStr($val)
    {
        if (!is_string($val)) return false;
        return true;
    }

    public function toLower($val)
    {
    if (!$this->isStr($val)) return false;

    return strtolower($val);
    }

    public function toUpper($val)
    {
        if (!$this->isStr($val)) return false;

        return strtoupper($val);
    }

}