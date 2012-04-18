Example usage
=============

```php
<?php

$m = new Mok;
$m->bar = 'baz';
$m->foo(5, 10); // last parameters is always return value

$mo = new Mok;
$mo->duck = 'quack';
$mo->lock();

$m->mo = $mo;
$m->lock();

print $m->foo(5) . PHP_EOL;   // prints 10
print $m->bar . PHP_EOL;      // prints baz
print $m->mo->duck . PHP_EOL; // prints quack
```
