<?php

class mok{
    private $locked = false;
    private $map = array();

    public function lock($locked = true)
    {
        $this->locked = (bool) $locked;
    }

    public function ad($fp,$r){
        $this->map[$fp] = $r;
        return $this;
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
            $this->map["$name(" . implode(',', $arguments) . ')'] = $returnValue;
            return $this;
        }
    }

    public function __toString()
    {
        return print_r($this->map, true);
    }
}
$m = new mok;
$m->bar = 'baz';
$m->foo(5, new mokc(10, 1, '>=')); // last parameters is always return value

$mo = new mok;
$mo->duck = 'quack';
$mo->lock();
$m->mo = $mo;

$m->lock();

print $m->foo(5) . PHP_EOL; // prints 10
print $m->bar . PHP_EOL; // prints baz
print $m->mo->duck . PHP_EOL;
