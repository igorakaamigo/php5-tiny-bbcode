# Tiny BBCode implementation for PHP 5.4+ and HHVM

This library includes a lightweight implementation of a BBCode subset to HTML translator.

[![License](https://img.shields.io/github/license/igorakaamigo/php5-tiny-bbcode.svg)](https://github.com/igorakaamigo/php5-tiny-bbcode/blob/master/LICENSE)
[![Packagist Version](https://img.shields.io/packagist/v/igorakaamigo/php5-tiny-bbcode.svg)](https://packagist.org/packages/igorakaamigo/php5-tiny-bbcode)
[![Minimal PHP Version](https://img.shields.io/packagist/php-v/igorakaamigo/php5-tiny-bbcode.svg)](http://php.net/downloads.php)

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
// Outputs: <strong>A bold string</strong>

echo BBCode::convert('<span>A text</span>');
// Outputs: &lt;span&gt;A text&lt;/span&gt;

echo BBCode::convert('[i]Hi&nbsp;there![/i]');
// Outputs: <em>Hi&amp;nbsp;there!</em>

echo BBCode::convert('[i]Hi&nbsp;there<br>!!![/i]', ['&nbsp;', '<br>']);
// Outputs: <em>Hi&nbsp;there<br>!!!</em>

echo BBCode::convert('Magic links: email me at xxx@yyy.com');
// Outputs: Magic links: email me at <a href="mailto:xxx@yyy.com">xxx@yyy.com</a>

echo BBCode::convert('Magic links: http://www.domain.tld/path/to/resource');
// Outputs: Magic links: <a href="http://www.domain.tld/path/to/resource">http://www.domain.tld/path/to/resource</a>
```

### Supported BBCodes

* [b]Bold string[/b]
* [i]Italic string[/i]
* [u]Underline string[/u]
* [s]Strikethrough string[/s]
* [email]xxx@yyy.com[/email]
* [url]http://www.domain.tld[/url]
* [url="http://www.domain.tld"]Another way to render a link[/url] (quotes inside url tag are not necessary)
* [img]http://www.domain.tld/upload/image.png[/img]
* [quote]A quotation[/quote]
* [quote="Quote author"]A quotation[/quote] (quotes inside quote tag are not necessary)
* [code]A program code sample[/code]
* [size="12"]A text written using a 12px-sized font[/size] (quotes inside size tag are not necessary)
* [size="10pt"]A text written using a 10pt-sized font[/size] (quotes inside size tag are not necessary)
* [color="#33FF33"]A green text line[/color] (quotes inside color tag are not necessary)
* [table], [tr], [td] – table-related tags
* [ul], [ol], [li], [*], [list], [list=1|a|A|i|I], [list="1|a|A|i|I"] – list-related tags

[attachment] tag is not supported yet.

## Contributing

Just a kata project. Anyway – if one is interested –


Fork --> modify --> pull-request
