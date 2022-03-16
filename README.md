# Fastwf Interpolation

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Fastwf_interpolation&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=Fastwf_interpolation)
[![Unit tests](https://github.com/Fastwf/interpolation/actions/workflows/test.yml/badge.svg)](https://github.com/Fastwf/interpolation/actions/workflows/test.yml)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=Fastwf_interpolation&metric=coverage)](https://sonarcloud.io/summary/new_code?id=Fastwf_interpolation)

## Introduction

String interpolation library.

> For all exemples, `vendor/autoload.php` must be included to allows auto
include.

## StringInterpolator

### Usage

```php
<?php
// test.php
// ...

use Fastwf\Interpolation\StringInterpolator;

$interpolator = new StringInterpolator();

echo $interpolator->interpolate(
    "Hello %{name} with injection escaped \%{name} or %{undefined} not injected.",
    ['name' => 'Fast Web Framework']
) . PHP_EOL;

```

This script execution produce the next output.

```bash
$ php test.php
Hello Fast Web Framework with injection escaped %{name} or %{undefined} not injected.
```

### Customise

It's possible to customise the behaviour of the interpolator.

#### Strict interpolation

Interpolation can be strict, in that case when a variable is not provided in
the parameter array an `InterpolationException` is thrown.

```php
<?php
///...
new StringInterpolator(true);
```

#### Different markers

Interpolation markers can be customized. For example use `#[...]` instead of `%{...}`.

```php
<?php
///...
new StringInterpolator(false, '#', '[', ']');
```

## LexInterpolator

### Usage

```php
<?php
// test.php
// ...

use Fastwf\Interpolation\LexInterpolator;


$interpolator = new LexInterpolator();

echo $interpolator->interpolate(
    "Hello %{name} with injection escaped \%{name}.",
    ['name' => 'Fast Web Framework']
) . PHP_EOL;

```

This script execution produce the next output.

```bash
$ php test.php
Hello Fast Web Framework with injection escaped \%{name}.
```

> It's not possible to inject undefined variables like `StringInterpolator`
because lex parse the template as node and node cannot be restored from its
original form.

### Customise

Like `StringInterpolator`, interpolation markers can be customized for `LexInterpolator`.

For example for `#[...]`:

```php
<?php
// ...

$interpolator = new LexInterpolator("#", "[", "]");

// ...
```
