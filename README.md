# Tiny BBCode implementation for PHP 5.4+

This library includes a lightweight implementation of a BBCode subset to HTML translator.

[![License](https://img.shields.io/github/license/igorakaamigo/php5-tiny-bbcode.svg)](https://github.com/igorakaamigo/php5-tiny-bbcode/blob/master/LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/igorakaamigo/php5-tiny-bbcode.svg)](https://packagist.org/packages/igorakaamigo/php5-tiny-bbcode)
[![Minimal PHP Version](https://img.shields.io/packagist/php-v/igorakaamigo/php5-tiny-bbcode.svg)](http://php.net/downloads.php)
[![Build Status](https://img.shields.io/travis/igorakaamigo/php5-tiny-bbcode/master.svg)](https://travis-ci.org/igorakaamigo/php5-tiny-bbcode)

## Features

* It's tiny, yep.
* PSR-4 autoloading compliant structure
* Unit-Testing with PHPUnit
* Easy to use to any framework or even a plain php file

## Installation

The suggested installation method is via [composer](https://getcomposer.org/):

```sh
php composer.phar require "igorakaamigo/php5-tiny-bbcode"
```

## Usage

```php
use \Igorakaamigo\Utils\BBCode;

echo BBCode::convert('[b]A bold string[/b]');
```

### Supported BBCodes

* [b]Bold string[/b]
* [i]Italic string[/i]
* [u]Underline string[/u]
* [s]Strikethrough string[/s]
* [url]http://www.domain.tld[/url]
* [url=http://www.domain.tld]Another way to render a link[/url]
* [img]http://www.domain.tld/upload/image.png[/img]
* [quote]A quotation[/quote]
* [code]A program code sample[/code]
* [size=12]A text written using a 12px-sized font[/size]
* [size="10pt"]A text written using a 10pt-sized font[/size]
* [color="#33FF33"]A green text line[/color]
* [ul], [ol], [li] – list-related tags
* [table], [tr], [td] – table-related tags

## Contributing

OMG! Really? Thanks a lot!

Fork --> modify --> pull-request
