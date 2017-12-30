# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- CHANGELOG.md
- Travis CI support file
- HHVM support
- New list synthax added ([list] / [*]) (according to documentation)
- [email] tag added

### Changed
- BBCode::convert() - added $ignoreHtml param with default value of []

### Fixed
- Quotes are made unnecessary @ [color] tag
- Quotes are made unnecessary @ [url] tag
- Quotes are made unnecessary @ [size] tag
- [li][/li] content is trimming now

### Removed
- Removed binding to htmlspecialchars() function

## [1.0.0] - 2017-12-28
### Added
- Basic library functionality (src/BBCode.php):
  - [b]Bold string[/b]
  - [i]Italic string[/i]
  - [u]Underline string[/u]
  - [s]Strikethrough string[/s]
  - [url]http://www.domain.tld[/url]
  - [url=http://www.domain.tld]Another way to render a link[/url]
  - [img]http://www.domain.tld/upload/image.png[/img]
  - [quote]A quotation[/quote]
  - [code]A program code sample[/code]
  - [size=12]A text written using a 12px-sized font[/size]
  - [size="10pt"]A text written using a 10pt-sized font[/size]
  - [color="#33FF33"]A green text line[/color], [color=#33FF33]A green text line[/color]
  - [ul], [ol], [li] – list-related tags
  - [table], [tr], [td] – table-related tags
- MIT LICENSE file
- PHPUnit tests (tests/BBCodeTest.php)
- PHPUnit configuration (/phpunit.xml)
- README.md
- Support files (.gitignore and composer.json)
