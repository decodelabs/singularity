# Singularity — Package Specification

> **Cluster:** `http`
> **Language:** `php`
> **Milestone:** `m3`
> **Repo:** `https://github.com/decodelabs/singularity`
> **Role:** URL parsing

## Overview

### Purpose

Singularity provides a unified interface for parsing and resolving URIs, PSR-7 URLs, and file paths. It consolidates URI parsing and manipulation into a single, consistent API.

Key features:
- **Unified parsing**: Parse URIs, URLs, URNs, and file paths with a single interface
- **PSR-7 compatibility**: Full PSR-7 `UriInterface` implementation
- **Immutable API**: All modifications return new instances
- **Path manipulation**: Rich path manipulation with file name, extension, and directory operations
- **Query parsing**: Parse query strings to `Tree` objects for easy manipulation
- **Scheme-aware**: Specialized handling for different URI schemes (HTTP, mailto, etc.)
- **Relative resolution**: Resolve relative URLs against base URLs

### Non-Goals

- Singularity does not provide HTTP client functionality.
- It does not handle URI validation beyond basic parsing.
- It does not provide URI routing or matching capabilities.
- It does not handle URI encoding/decoding beyond standard normalization.
- It does not provide URI comparison or sorting utilities.

## Role in the Ecosystem

### Cluster & Positioning

Singularity belongs to the **http** cluster, focusing on HTTP-related functionality. It complements other HTTP packages like `harvest` (HTTP stack) and `greenleaf` (HTTP routing) by providing URI parsing and manipulation capabilities.

### Usage Contexts

- **HTTP applications**: Parsing and manipulating URLs in web applications
- **PSR-7 integration**: Providing PSR-7 compatible URI objects
- **File path handling**: Parsing and manipulating file paths
- **Query string parsing**: Parsing and manipulating query strings
- **Relative URL resolution**: Resolving relative URLs against base URLs

## Public Surface

### Key Types

- **`Singularity`** (class): Main entry point providing static factory methods for creating URI, URL, URN, and Path instances. Implements `PureService` for Kingdom integration.

- **`Uri`** (interface): Base interface for all URI types. Defines scheme access and parsing.

- **`Url`** (interface): Interface for URL types extending `Uri` and `UriInterface`. Defines methods for accessing and modifying URL components (scheme, user info, host, port, path, query, fragment).

- **`Url\Generic`** (class): Generic URL implementation supporting all URL components. Implements `Rebasable` for relative URL resolution.

- **`Url\Http`** (class): HTTP/HTTPS URL implementation with scheme-specific port handling and security checks.

- **`Url\Mailto`** (class): Mailto URL implementation with email address extraction and query support.

- **`Url\Rebasable`** (interface): Interface for URLs that can be rebased against a base URL.

- **`Urn`** (interface): Interface for URN types extending `Uri`. Defines namespace and identifier access.

- **`Urn\Generic`** (class): Generic URN implementation.

- **`Path`** (class): File path implementation extending `ImmutableSequence`. Provides file name, extension, directory, and canonicalization operations.

- **`Factory`** (class): PSR-7 URI factory implementation.

### Main Entry Points

**Factory Methods:**
- `Singularity::uri(string|PsrUri|Uri|null $uri): ?Uri` — Parse any URI
- `Singularity::url(string|PsrUri|Uri|null $uri, string|PsrUri|Uri|null $relativeTo = null): ?Url` — Parse URL (optionally rebase)
- `Singularity::urn(string|Uri|null $uri): ?Urn` — Parse URN
- `Singularity::path(string|Path|Url|null $path, ?string $separator = null): ?Path` — Parse file path
- `Singularity::canonicalPath(string|Path|Url|null $path, ?string $separator = null): ?Path` — Parse and canonicalize path

**Uri Interface:**
- `Uri::fromString(string $uri): static` — Create from string
- `$uri->scheme` — Scheme (readonly property)
- `$uri->getScheme(): string` — Get scheme

**Url Interface:**
- `$url->username` — Username (readonly property)
- `$url->password` — Password (readonly property)
- `$url->host` — Host (readonly property)
- `$url->port` — Port (readonly property)
- `$url->authority` — Authority (readonly property)
- `$url->path` — Path (readonly property)
- `$url->query` — Query (readonly property)
- `$url->fragment` — Fragment (readonly property)
- `$url->withScheme(string|Closure $scheme): static` — Modify scheme
- `$url->hasScheme(): bool` — Check if scheme exists
- `$url->withUsername(string|Closure|null $username): static` — Modify username
- `$url->getUsername(): string` — Get username
- `$url->hasUsername(): bool` — Check if username exists
- `$url->withPassword(string|Closure|null $password): static` — Modify password
- `$url->getPassword(): string` — Get password
- `$url->hasPassword(): bool` — Check if password exists
- `$url->withUserInfo(string|Closure|null $username, ?string $password = null): static` — Modify user info
- `$url->hasUserInfo(): bool` — Check if user info exists
- `$url->withHost(string|Ip|Closure|null $host): static` — Modify host
- `$url->hasHost(): bool` — Check if host exists
- `$url->withPort(int|string|Closure|null $port): static` — Modify port
- `$url->hasPort(): bool` — Check if port exists
- `$url->withPath(string|Path|Closure|null $path): static` — Modify path
- `$url->parsePath(): ?Path` — Parse path to Path object
- `$url->hasPath(): bool` — Check if path exists
- `$url->withQuery(string|array|Tree|Closure|null $query): static` — Modify query
- `$url->parseQuery(): Tree` — Parse query to Tree object
- `$url->hasQuery(): bool` — Check if query exists
- `$url->withFragment(string|Closure|null $fragment): static` — Modify fragment
- `$url->hasFragment(): bool` — Check if fragment exists
- `$url->isJustFragment(): bool` — Check if URL is just a fragment

**Url\Http:**
- `$url->isSecure(): bool` — Check if HTTPS

**Url\Mailto:**
- `$url->getEmailAddress(): string` — Get email address

**Url\Rebasable:**
- `$url->rebase(Url $base): static` — Rebase against base URL

**Urn Interface:**
- `$urn->namespace` — Namespace (readonly property)
- `$urn->identifier` — Identifier (readonly property)
- `$urn->getNamespace(): string` — Get namespace
- `$urn->withIdentifier(string|Closure $identifier): static` — Modify identifier
- `$urn->getIdentifier(): string` — Get identifier

**Path:**
- `Path::fromString(string $path, ?string $separator = null): static` — Create from string
- `$path->separator` — Path separator (readonly property)
- `$path->leadingSlash` — Has leading slash (readonly property)
- `$path->trailingSlash` — Has trailing slash (readonly property)
- `$path->dirName` — Directory name (readonly property)
- `$path->baseName` — Base name (readonly property)
- `$path->fileName` — File name (readonly property)
- `$path->fileRoot` — File root without extension (readonly property)
- `$path->extension` — File extension (readonly property)
- `$path->withLeadingSlash(bool $slash): static` — Modify leading slash
- `$path->hasLeadingSlash(): bool` — Check if has leading slash
- `$path->withTrailingSlash(bool $slash): static` — Modify trailing slash
- `$path->hasTrailingSlash(): bool` — Check if has trailing slash
- `$path->withSeparator(string $separator): static` — Modify separator
- `$path->getSeparator(): string` — Get separator
- `$path->canonicalize(): static` — Canonicalize path (resolve `.` and `..`)
- `$path->getDirName(): string` — Get directory name
- `$path->withBaseName(string $baseName): static` — Modify base name
- `$path->getBaseName(): ?string` — Get base name
- `$path->withFileName(?string $name): static` — Modify file name
- `$path->getFileName(): ?string` — Get file name
- `$path->withFileRoot(?string $root): static` — Modify file root
- `$path->getFileRoot(): ?string` — Get file root
- `$path->withExtension(?string $extension): static` — Modify extension
- `$path->getExtension(): ?string` — Get extension
- `$path->hasExtension(string ...$extensions): bool` — Check if has extension(s)

**Factory:**
- `Factory::createUri(string $uri = ''): UriInterface` — Create PSR-7 URI

## Dependencies

### Decode Labs

- **`decodelabs/archetype`**: Used for scheme-specific URL/URN class resolution.
- **`decodelabs/collections`**: Used for `Tree` class in query parsing and `ImmutableSequence` base for `Path`.
- **`decodelabs/compass`**: Used for IP address parsing and validation in host handling.
- **`decodelabs/exceptional`**: Used for exception handling throughout the package.
- **`decodelabs/kingdom`**: Used for service container integration (`PureService`).
- **`decodelabs/monarch`**: Used for service location (Archetype).
- **`decodelabs/nuance`**: Used for `Dumpable` interface support, enabling debugging and inspection capabilities.

### External

- **PHP**: See `composer.json` for supported PHP versions.
- **`psr/http-factory`**: PSR-17 factory interfaces.
- **`psr/http-message`**: PSR-7 message interfaces.

## Behaviour & Contracts

### Invariants

- All URI/URL/URN/Path instances are immutable (modifications return new instances).
- Scheme names are normalized to lowercase.
- Ports are normalized to integers or null.
- Paths preserve leading/trailing slashes as specified.
- Query strings are normalized according to RFC 3986.
- Fragments are normalized (percent-encoded as needed).

### Input & Output Contracts

**URI Parsing:**
- `uri()` returns `null` if input is `null`.
- `uri()` returns existing `Uri` instance if input is already a `Uri`.
- `uri()` converts PSR-7 `UriInterface` to string for parsing.
- Scheme detection uses regex pattern matching.
- Unknown schemes default to HTTP for URLs.
- URNs require valid namespace identifier.

**URL Parsing:**
- `url()` throws `InvalidArgument` if URI is not a URL (e.g., is a URN).
- `url()` supports rebasing if URL implements `Rebasable` and `relativeTo` is provided.
- Scheme-specific classes are resolved via Archetype (e.g., 'http' → `Url\Http`).
- Generic URL class is used as fallback.

**Path Parsing:**
- `path()` extracts path from URL if input is a `Url`.
- `path()` detects separator from path string (backslash if only backslashes present, forward slash otherwise).
- `file://` protocol prefix is stripped automatically.
- Leading and trailing slashes are preserved.

**Path Canonicalization:**
- `canonicalize()` resolves `.` (current directory) references.
- `canonicalize()` resolves `..` (parent directory) references.
- Empty segments are removed.
- Leading `..` segments are preserved.

**Query Parsing:**
- `parseQuery()` returns `Tree` object with parsed query parameters.
- Query values are coerced to appropriate types (int, float, bool, string).
- Array notation (`key[]=value`) creates arrays in Tree.
- Nested structures are supported.

**Relative URL Resolution:**
- `rebase()` resolves relative URLs against base URL.
- Scheme, authority, and path are resolved according to RFC 3986.
- Fragment is preserved from relative URL.

## Error Handling

- **Invalid URI**: `fromString()` throws `InvalidArgument` exceptions for unparseable URIs.
- **Invalid URN**: URN parsing throws `InvalidArgument` exceptions for invalid namespace or format.
- **Invalid scheme**: HTTP URL normalization throws `InvalidArgument` exceptions for unsupported schemes.
- **Not a URL**: `url()` throws `InvalidArgument` exceptions if URI is not a URL (e.g., is a URN).
- **Not a URN**: `urn()` throws `InvalidArgument` exceptions if URI is not a URN.

## Configuration & Extensibility

### Creating Custom URL Types

Register custom URL classes via Archetype:

```php
use DecodeLabs\Archetype;
use DecodeLabs\Singularity\Url;

// Register custom scheme handler
$archetype->register(Url::class, 'myscheme', MySchemeUrl::class);

// Now parsing 'myscheme://...' will use MySchemeUrl
$url = Singularity::url('myscheme://example.com');
```

### Creating Custom URN Types

Register custom URN classes via Archetype:

```php
use DecodeLabs\Archetype;
use DecodeLabs\Singularity\Urn;

// Register custom namespace handler
$archetype->register(Urn::class, 'mynamespace', MyNamespaceUrn::class);

// Now parsing 'urn:mynamespace:...' will use MyNamespaceUrn
$urn = Singularity::urn('urn:mynamespace:identifier');
```

### Extending Path

Path extends `ImmutableSequence`, so it inherits all sequence operations:

```php
$path = Singularity::path('/path/to/file.txt');

// Use sequence operations
$newPath = $path->append('subdirectory');
$newPath = $path->prepend('root');
$newPath = $path->slice(0, -1); // Remove last segment
```

## Interactions with Other Packages

- **Archetype**: Used for scheme-specific URL/URN class resolution.
- **Collections**: Used for `Tree` query parsing and `ImmutableSequence` base for `Path`.
- **Compass**: Used for IP address parsing and validation.
- **Monarch**: Used for service location (Archetype).
- **Kingdom**: Used for service container integration.
- **Nuance**: Used for debugging and inspection capabilities.
- **Harvest**: Singularity URLs can be used with Harvest HTTP stack.
- **Greenleaf**: Singularity URLs can be used with Greenleaf routing.

## Usage Examples

### Basic URI Parsing

```php
use DecodeLabs\Singularity;

// Parse any URI
$uri = Singularity::uri('mailto:info@example.com');

// Parse URL
$url = Singularity::url('http://user:pass@www.example.com:8080/resource/page.html?param1=value1&param2=value2#section1');

// Parse URN
$urn = Singularity::urn('urn:isbn:0-486-27557-4');
echo $urn->getNamespace(); // isbn
echo $urn->getIdentifier(); // 0-486-27557-4
```

### URL Manipulation

```php
use DecodeLabs\Singularity;

$url = Singularity::url('http://example.com/path?key=value');

// Modify components
$newUrl = $url
    ->withScheme('https')
    ->withHost('www.example.com')
    ->withPath('/new/path')
    ->withQuery(['key' => 'newvalue', 'other' => 'value']);

// Using closures
$newUrl = $url->withPath(function($path, $url) {
    return $path . '/appended';
});
```

### Query String Parsing

```php
use DecodeLabs\Singularity;

$url = Singularity::url('http://www.example.com?param1=value1&param2=value2');
$tree = $url->parseQuery();

echo $tree->param2->as('string'); // value2

// Update query
$newUrl = $url->withQuery(function($tree, $url) {
    $tree->param2 = 'newValue2';
    $tree->param3 = 'value3';
    return $tree;
});
```

### Path Manipulation

```php
use DecodeLabs\Singularity;

// Parse path
$path = Singularity::path('/path/to/file.txt');

// Get components
echo $path->dirName; // /path/to/
echo $path->fileName; // file.txt
echo $path->fileRoot; // file
echo $path->extension; // txt

// Modify components
$newPath = $path
    ->withFileName('newfile.php')
    ->withExtension('json')
    ->withBaseName('renamed');

// Canonicalize
$canonical = Singularity::canonicalPath('/path/to/inner/./directory/../../file.txt');
// Result: /path/to/file.txt
```

### Relative URL Resolution

```php
use DecodeLabs\Singularity;

$base = Singularity::url('http://example.com/base/path/');
$relative = Singularity::url('../other/page.html', $base);

// Automatically rebased to: http://example.com/base/other/page.html
```

### Mailto URLs

```php
use DecodeLabs\Singularity;

$mailto = Singularity::url('mailto:user@example.com?subject=Hello&body=Hi%20there');
echo $mailto->getEmailAddress(); // user@example.com

$tree = $mailto->parseQuery();
echo $tree->subject->as('string'); // Hello
```

### PSR-7 Integration

```php
use DecodeLabs\Singularity\Factory;
use Psr\Http\Message\UriInterface;

$factory = new Factory();
$uri = $factory->createUri('http://example.com/path');

// Use with PSR-7 request/response
$request = $request->withUri($uri);
```

### Path from URL

```php
use DecodeLabs\Singularity;

$url = Singularity::url('http://example.com/path/to/file.txt');
$path = $url->parsePath();

// Modify path and update URL
$newUrl = $url->withPath(function($path) {
    return $path->withFileName('newfile.txt');
});
```

## Implementation Notes (for Contributors)

### Scheme Resolution

- Scheme detection uses regex: `/^([a-z][a-z0-9+.-]*):/i`
- Scheme names are normalized to lowercase and capitalized for class name.
- HTTPS is normalized to HTTP for class resolution (both use `Url\Http`).
- Unknown schemes default to HTTP (generic URL).
- Scheme-specific classes are resolved via Archetype.

### URN Parsing

- URN format: `urn:{namespace}:{identifier}`
- Namespace must match: `[a-z0-9][a-z0-9-]{1,31}`
- Namespace-specific classes are resolved via Archetype.
- Generic URN class is used as fallback.

### Path Parsing

- Separator detection checks for backslashes vs forward slashes.
- `file://` protocol prefix is stripped.
- Leading/trailing slashes are preserved as flags.
- Path segments are stored as array items in `ImmutableSequence`.

### Path Canonicalization

- `.` segments are removed.
- `..` segments remove previous segment (if not `..`).
- Empty segments are removed.
- Leading `..` segments are preserved (cannot go above root).

### Query Parsing

- Query strings are parsed to `Tree` objects.
- Values are coerced: numeric strings → int/float, 'true'/'false' → bool.
- Array notation (`key[]=value`) creates arrays.
- Nested structures use dot notation in Tree.

### Relative URL Resolution

- Resolution follows RFC 3986 algorithm.
- Scheme from base URL if relative URL has no scheme.
- Authority from base URL if relative URL has no authority.
- Path resolution handles absolute and relative paths.
- Query and fragment from relative URL if present.

### Immutability

- All modification methods return new instances.
- Cloning is used internally for efficient copying.
- Properties are readonly (protected(set) access).

## Testing & Quality

**Current Status:**
- Code quality: 4/5
- README quality: 3/5
- Documentation: 0/5 (no formal docs yet)
- Tests: 0/5 (no test suite yet)

**Testing Considerations:**
- URI parsing should be tested for:
  - Various URI schemes
  - Invalid URIs
  - Edge cases (empty components, special characters)
  - PSR-7 compatibility

- URL parsing should be tested for:
  - HTTP/HTTPS URLs
  - Mailto URLs
  - URLs with all components
  - URLs with missing components
  - Relative URL resolution

- URN parsing should be tested for:
  - Various URN namespaces
  - Invalid URNs
  - Namespace-specific handling

- Path parsing should be tested for:
  - Unix paths
  - Windows paths
  - File URLs
  - Separator detection
  - Leading/trailing slashes

- Path manipulation should be tested for:
  - File name operations
  - Extension operations
  - Directory operations
  - Canonicalization

- Query parsing should be tested for:
  - Simple queries
  - Array notation
  - Nested structures
  - Type coercion

## Roadmap & Future Ideas

- **Additional URL schemes**: Support for more URL schemes (ftp, data, etc.)
- **URI validation**: Enhanced URI validation beyond basic parsing
- **URI comparison**: Utilities for comparing and sorting URIs
- **URI templates**: Support for URI templates (RFC 6570)
- **Internationalized domain names**: Support for IDN parsing and encoding
- **Performance optimization**: Caching of parsed URIs
- **Batch operations**: Utilities for batch URI parsing and manipulation

## References

- Package repository: https://github.com/decodelabs/singularity
- Composer package: https://packagist.org/packages/decodelabs/singularity
- RFC 3986: https://tools.ietf.org/html/rfc3986 (URI Generic Syntax)
- PSR-7: https://www.php-fig.org/psr/psr-7/ (HTTP Message Interfaces)
- PSR-17: https://www.php-fig.org/psr/psr-17/ (HTTP Factories)
- Related packages:
  - `decodelabs/archetype` — Class resolution
  - `decodelabs/collections` — Tree and sequence support
  - `decodelabs/compass` — IP address parsing
  - `decodelabs/harvest` — HTTP stack (uses Singularity URLs)
  - `decodelabs/greenleaf` — HTTP routing (uses Singularity URLs)

