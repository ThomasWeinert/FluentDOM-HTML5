FluentDOM-HTML5
===============

[![License](https://poser.pugx.org/fluentdom/html5/license.svg)](http://www.opensource.org/licenses/mit-license.php)
[![CI](https://github.com/ThomasWeinert/FluentDOM-HTML5/actions/workflows/ci.yml/badge.svg)](https://github.com/ThomasWeinert/FluentDOM-HTML5/actions/workflows/ci.yml)
[![Total Downloads](https://poser.pugx.org/fluentdom/html5/downloads.svg)](https://packagist.org/packages/fluentdom/html5)
[![Latest Stable Version](https://poser.pugx.org/fluentdom/html5/v/stable.svg)](https://packagist.org/packages/fluentdom/html5)
[![Latest Unstable Version](https://poser.pugx.org/fluentdom/html5/v/unstable.svg)](https://packagist.org/packages/fluentdom/html5)


Adds support for HTML5 to FluentDOM. It adds a loader and a serializer. It uses the
[HTML5-PHP](https://github.com/Masterminds/html5-php) library.

Installation
------------

```text
composer require fluentdom/html5
```

Loader
------

The loader registers automatically. You can trigger it with the types `html5` and `text/html5`.

```php
$document = FluentDOM::load($html5, 'text/html5');
$query = FluentDOM($html5, 'text/html5');
```

Serializer
----------

The serializer needs to be created with for document and can be casted into a string.

```php
echo new FluentDOM\Html5\Serializer($document);
```



