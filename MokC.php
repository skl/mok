<?php

class MokC
{

    private $returnValue = null;

    private $expectedAccess = null;

    public function __construct($returnValue, $expectedAccess)
    {
        $this->returnValue = $returnValue;
        $this->expectedAccess = $expectedAccess;
    }

    public function getReturnValue()
    {
        return $this->returnValue;
    }
}
