L4ToString
========

[![Latest Stable Version](https://poser.pugx.org/xethron/l4-to-string/v/stable.png)](https://packagist.org/packages/xethron/l4-to-string) [![Total Downloads](https://poser.pugx.org/xethron/l4-to-string/downloads.png)](https://packagist.org/packages/xethron/l4-to-string) [![Latest Unstable Version](https://poser.pugx.org/xethron/l4-to-string/v/unstable.png)](https://packagist.org/packages/xethron/l4-to-string) [![License](https://poser.pugx.org/xethron/l4-to-string/license.png)](https://packagist.org/packages/xethron/l4-to-string)

Logging variables can sometimes cause huge logs, especially if you want to email those logs to yourself.

On the other hand, logging exceptions with the default __toString can will most likely give you just enough information to confuse the hell out of you!

This class extends Xethron\ToString, and in addition, adds a few Laravel 4 specific functions for converting Query Logs to Strings.

Variable to String
==================

This is a function that will display a variable similar to print_r, with the ability to specify the max_lines, max_depth (for arrays) and min_depth (for arrays).

This means that you will never get an email with an array 3000 lines long as you would with print_r.

`Xethron\L4ToString::variable( $var, $max_lines, $max_depth, $min_depth )`

I recommend adding a global function to one of your startup files for easier access:

```php
function varToStr( $var, $max_lines = 10, $max_depth = 4, $min_depth = 2 )
{
    return Xethron\L4ToString::variable( $var, $max_lines, $max_depth, $min_depth );
}
```
Exception to String
===================

This converts an Exception to string, much like PHP's __toString, however, it won't cut off those important pieces of information you require while debugging.

On top of that, it also uses the Variable to String to to include all the variables passed in the Stack Trace.

Two functions are available:
---------------------------

`Xethron\L4ToString::exception( $e ); // This will print out the entire Exception`

`Xethron\L4ToString::trace( $e->getTrace() ); // This will only print out the stack trace`

Query Log to String
===================

This will convert the Laravel 4 Query Log to a neat Query String like:
```txt
#0 select * from `table` where `table`.`id` = 113 and `deleted` = 0 limit 1;
    {"bindings":[113,0],"time":1.08}
#1 select * from `another_table` where `another_table`.`deleted_at` is null and `id` = '66' limit 1;
	{"bindings":["66"],"time":0.49}
#2 select * from `country` where `country`.`deleted` = 0 and `country`.`name` in ('South Africa');
	{"bindings":[0,"South Africa"],"time":0.51}
```

Two Functions are available:
----------------------------

`Xethron\L4ToString::queryLog(); // gets the latest query log and prints it`
`Xethron\L4ToString::queryLog( \DB::getQueryLog() ); // Specify your own query log`
`Xethron\L4ToString::query( $qyery ); // Pass a single query from the query log to be converted to string`

License
=======

L4ToString is distributed under the terms of the GNU General Public License, version 3 or later.