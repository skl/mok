<?php

require_once 'MokC.php';

class Mok
{
    private $locked = false;

    private $map = array();

    public function lock($locked = true)
    {
        $this->locked = (bool) $locked;
    }

    public function __set($name, $value)
    {
        $this->map[$name] = $value;
        return $this;
    }

    public function __get($name)
    {
        return $this->map[$name];
    }

    public function __call($name, $arguments)
    {
        if ($this->locked) {
            $fp = "$name(" . implode(',', $arguments) . ")";
            return in_array($fp,array_keys($this->map)) ? $this->map[$fp] : 'not implemented';
        } else {
            $returnValue = array_pop($arguments);

            if ($returnValue instanceof MokC) {
                // TODO handle expected access
                $returnValue = $returnValue->getReturnValue();
            }

            $this->map["$name(" . implode(',', $arguments) . ')'] = $returnValue;
            return $this;
        }
    }

    public function __toString()
    {
        return print_r($this->map, true);
    }
}
