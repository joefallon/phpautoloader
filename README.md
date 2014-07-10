# Joe's PHP Autoloader

Joe's PHP Autoloader is a versatile and easy to use autoloader for PHP 5.3.

## Requirements

The only requirement is PHP > 5.3.0 due to the use of
[namespaces](http://www.php.net/manual/en/language.namespaces.rationale.php).
Additionally, [Composer](https://getcomposer.org/) can be helpful as well.
 
## Features

Joe's Autoloader includes the following features:

* Will load (i.e. require) classes that are namespaced with normal backslash PHP
  namespaces, underscore (e.g. Zend Framework 1, PEAR) namespaces, and classes
  that are not namespaced at all.
* Searches for classes within the include path efficiently for quick loading.

## Installtion

The easiest way to install Joe's Autoloader is with
[Composer](https://getcomposer.org/). Create the following `composer.json` file
and run the `php composer.phar install` command to install it.

```json
{
    "require": {
        "joefallon/Autoloader": "*"
    }
}
```

## Usage

To use Joe's Autoloader, the following initialization steps are needed:

* Add the base directories where classes can be found to the include path.
* Call the `Autoloader::registerAutoload()` method to load the autoloader.
* Start using classes with your code.

```php
<?php

use JoeFallon\Autoloader;

// Define the include paths.
define('BASE_PATH', realpath(dirname(__FILE__).'/../'));
define('LIB_PATH',  BASE_PATH.'/lib');
define('VEND_PATH', BASE_PATH.'/vendor');

// Set the application include paths for autoloading.
set_include_path(get_include_path().':'.LIB_PATH.':'.BASE_PATH);

// Require the Composer autoloader.
require(VEND_PATH.'/autoload.php');

// Initialize Joe's Autoloader.
Autoloader::registerAutoLoad();
```

As long as namespaces are mapped to the folder structure within the directories
defined above, then autoloader will have no problems finding and loading classes.

For example, let's assume we want to load the class `Bar` that is within the file
named `Bar.php` contained within a folder `Foo`. Also, let's assume that the class
`Bar` is namespaced `\Foo\Bar`. This gives a path of `LIB_PATH/Foo/Bar.php`. When
`new Bar();` is exectuded, the `Bar` class will be loaded (if is isn't already).


