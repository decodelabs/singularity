# Singularity

[![PHP from Packagist](https://img.shields.io/packagist/php-v/decodelabs/singularity?style=flat)](https://packagist.org/packages/decodelabs/singularity)
[![Latest Version](https://img.shields.io/packagist/v/decodelabs/singularity.svg?style=flat)](https://packagist.org/packages/decodelabs/singularity)
[![Total Downloads](https://img.shields.io/packagist/dt/decodelabs/singularity.svg?style=flat)](https://packagist.org/packages/decodelabs/singularity)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/decodelabs/singularity/Integrate)](https://github.com/string|int|floatdecodelabs/singularity/actions/workflows/integrate.yml)
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
    Singularity::url('mailto:user@example.com?subject=Hello&body=Hi%20there'),
    Singularity::url('tel:+1-816-555-1212'),

    // ::urn() will parse any valid URN
    Singularity::urn('urn:isbn:0-486-27557-4'),
    Singularity::urn('urn:ietf:rfc:3986'),
    Singularity::urn('urn:oid:2.16.840')
);
```

## Licensing

Singularity is licensed under the proprietary License. See [LICENSE](./LICENSE) for the full license text.
