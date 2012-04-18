<?php

require_once 'MokC.php';

class Mok
{
    /**
     * @access private
     * @var boolean $locked
     */
    private $locked = false;
    
    /**
     * @access private
     * @var $map
     */
    private $map = array();
    
    /**
     * lock object so methods can be executed
     *
     * @access public
     * @param boolean $locked
     * @return void
     */
    public function lock($locked = true)
    {
        $this->locked = (bool) $locked;
    }
    
    /**
     * 
     * @access public
     * @param $input 
     * @param $output the expected return value
     */
    public function __set($input, $output)
    {
        $this->map[$input] = $output;
        return $this;
    }
    
    /**
     * @param $name
     * @return $map
     */
    public function __get($name)
    {
        return $this->map[$name];
    }

    /**
     * @access public
     * @param $name
     * @param $arguments
     */
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
    
    /**
     * @access public
     * @return string
     */
    public function __toString()
    {
        return print_r($this->map, true);
    }
}
