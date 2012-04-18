Example usage
=============

```php
<?php

$m = new Mok;

// Create public property 'bar' with value 'baz'
$m->bar = 'baz';

// Create method 'foo', expecting one parameter '5', returning 10
$m->foo(5, 10); // last parameter is always return value

$mo = new Mok;
$mo->duck = 'quack';
$mo->lock(); // lock() prevents further methods from being created, allowing for execution instead

$m->mo = $mo;
$m->lock();

print $m->foo(5) . PHP_EOL;   // prints 10
print $m->bar . PHP_EOL;      // prints baz
print $m->mo->duck . PHP_EOL; // prints quack
```
