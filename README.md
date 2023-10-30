# Singularity

[![PHP from Packagist](https://img.shields.io/packagist/php-v/decodelabs/singularity?style=flat)](https://packagist.org/packages/decodelabs/singularity)
[![Latest Version](https://img.shields.io/packagist/v/decodelabs/singularity.svg?style=flat)](https://packagist.org/packages/decodelabs/singularity)
[![Total Downloads](https://img.shields.io/packagist/dt/decodelabs/singularity.svg?style=flat)](https://packagist.org/packages/decodelabs/singularity)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/decodelabs/singularity/Integrate)](https://github.com/decodelabs/singularity/actions/workflows/integrate.yml)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-44CC11.svg?longCache=true&style=flat)](https://github.com/phpstan/phpstan)
[![License](https://img.shields.io/packagist/l/decodelabs/singularity?style=flat)](https://packagist.org/packages/decodelabs/singularity)

### Consolidated URI parsing and resolving

Singularity provides a unified interface for parsing and resolving URIs, PSR-7 URLs and file paths.

_Get news and updates on the [DecodeLabs blog](https://blog.decodelabs.com)._

---

## Installation

Install via Composer:

```bash
composer require decodelabs/singularity
```

## Usage

Parse and normalize URIs:

```php
use DecodeLabs\Singularity;

dd(
    // ::uri() will parse any valid URI
    Singularity::uri('mailto:info@example.com'),

    // ::url() will parse any valid URL
    Singularity::url('http://user:pass@www.example.com:8080/resource/page.html?param1=value1&param2=value2#section1'),
    Singularity::url('ftp://ftp.example.com/files/document.pdf'),
    Singularity::url('mailto:user@example.com?subject=Hello&body=Hi%20there')->getEmailAddress(),
    Singularity::url('tel:+1-816-555-1212'),

    // ::urn() will parse any valid URN
    Singularity::urn('urn:isbn:0-486-27557-4'),
    Singularity::urn('urn:ietf:rfc:3986')->getNamespace(), // ietf
    Singularity::urn('urn:oid:2.16.840')->getIdentifier(), // 2.16.840
);
```

Parse query strings to <code>Tree</code>:

```php
use DecodeLabs\Singularity;

$url = Singularity::uri('http://www.example.com?param1=value1&param2=value2');
$tree = $url->parseQuery();
echo $tree->param2->as('string'); // value2

// Update query
$newUrl = $url->withQuery(function($tree, $url) {
    $tree->param2 = 'newValue2';
    $tree->param3 = 'value3';
    return $tree;
});
```

Parse and normalize file paths:

```php
use DecodeLabs\Singularity;

dd(
    // ::path() will parse any valid file path
    Singularity::path('/path/to/file.txt'),
    Singularity::path('C:\path\to\file.txt'),
    Singularity::path('file:///path/to/file.txt'),
    Singularity::path('file://C:/path/to/file.txt'),

    // ::canonicalPath() will parse any valid file path and normalize it
    Singularity::canonicalPath('/path/to/inner/./directory/../../file.txt'), // /path/to/file.txt
);

$url = Singularity::uri('http://www.example.com?param1=value1&param2=value2');
$url->withPath(function($path) {
    $path->setFileName('file.txt');
    return $path;
});
```

## Licensing

Singularity is licensed under the proprietary License. See [LICENSE](./LICENSE) for the full license text.
