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

### Add transform functions

The `LexInterpolator` allows to transform values thanks to the pipe syntax.

A pipe is required when the value cannot be transformed as string or when the value must be updated before injection.  
The next example show how to format a date and transform it before injection in the template.

```php
// test.php
// ...

$interpolator = new LexInterpolator();

$interpolator->getEnvironment()
    ->setPipe('date', new PipeFunction(
        function ($date, $format) {
            return $date->format($format);
        })
    )
    ->setPipe('lower', new PipeFunction(
        function ($str) {
            return mb_strtolower($str);
        }
    ))
    ;

echo $interpolator->interpolate(
    "Today is %{ today | date('l jS F Y') | lower }.",
    ['today' => new DateTime('2022-03-16')]
) . PHP_EOL;
```

This script execution produce the next output.

```bash
$ php test.php
Today is wednesday 16th march 2022.
```

### Customise

Like `StringInterpolator`, interpolation markers can be customized for `LexInterpolator`.

For example for `#[...]`:

```php
<?php
// ...

$interpolator = new LexInterpolator("#", "[", "]");

// ...
```
