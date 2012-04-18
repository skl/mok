<?php
/**
 * Mok
 *
 * @package Mok
 * @author  "Adam McAuley" <amcauley@plus.net>
 * @author  "Stephen Lang" <slang@plus.net>
 * @link    https://github.com/skl/mok
 */

require_once 'MokC.php';

/**
 * Mok
 *
 * @package Mok
 * @author  "Adam McAuley" <amcauley@plus.net>
 * @author  "Stephen Lang" <slang@plus.net>
 * @link    https://github.com/skl/mok
 */
class Mok
{
    /**
     * @var boolean $locked FALSE allows methods to be added to $map
     */
    private $_locked = false;

    /**
     * @var array $map Hashmap containing function signatures and return values
     */
    private $_map = array();

    /**
     * Lock object so that previously created methods can be executed
     *
     * @param boolean $locked TRUE (default) prevents further methods from
     *                        being added to the hashmap
     *
     * @return Mok
     */
    public function ___lock($locked = true)
    {
        $this->_locked = (bool) $locked;
        return $this;
    }

    /**
     * Magic setter used for creating mock properties
     *
     * @param string $property    The name of the mock property to create
     * @param mixed  $returnValue The value to return upon property access
     *
     * @return Mok
     */
    public function __set($property, $returnValue)
    {
        if (!$this->_locked) {
            $this->_map[$property] = $returnValue;
        }
        return $this;
    }

    /**
     * Magic getter used to access mock properties
     *
     * @param string $property The name of the property to access
     *
     * @return mixed The return value of the property
     */
    public function __get($property)
    {
        return $this->_map[$property];
    }

    /**
     * Magic method used to create mock methods (when unlocked) or execute mock
     * methos (when locked).
     *
     * @param string $methodName The name of the method to create/execute
     * @param array  $arguments  The arguments to expect/pass to the method.
     *                           Final argument when creating a method is always the return value.
     *
     * @return mixed The return value of the method
     */
    public function __call($methodName, $arguments)
    {
        if ($this->_locked) {
            $fp = "$methodName(" . implode(',', $arguments) . ")";
            return in_array(
                $fp,
                array_keys($this->_map)
            ) ? $this->_map[$fp] : throw new Exception("Method {$methodName}() was not defined!");
        } else {

            $returnValue = array_pop($arguments);

            if ($returnValue instanceof MokC) {
                // TODO handle expected access
                $returnValue = $returnValue->getReturnValue();
            }

            $this->_map["$name(" . implode(',', $arguments) . ')'] = $returnValue;
            return $this;
        }
    }

    /**
     * Magic toString method provides string representation of the hashmap for
     * debugging purposes
     *
     * @return string
     */
    public function __toString()
    {
        return print_r($this->_map, true);
    }
}
