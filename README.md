# Fastwf Interpolation

## Introduction

String interpolation library.

## Usage

```php
<?php
// test.php

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

## Customise

It's possible to customise the behaviour of the interpolator.

### Strict interpolation

Interpolation can be strict, in that case when a variable is not provided in
the parameter array an `InterpolationException` is thrown.

```php
<?php
///...
new StringInterpolator(true);
```

### Different markers

Interpolation markers can be customized. For example use `#[...]` instead of `%{...}`.

```php
<?php
///...
new StringInterpolator(false, '#', '[', ']');
```
