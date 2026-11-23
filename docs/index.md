---
title: Introduction
intro: Decimal numbers of any size for PHP, built on the BCMath extension. Every number is an immutable value object.
group: Getting started
order: 10
---

## Requirements

The library needs a current PHP version and the BCMath extension, which does the calculations.

- PHP 8.4 or newer
- The `bcmath` extension

## Installation

Install the library with Composer. This also checks that the BCMath extension is available.

```bash
composer require phpmath/bignumber
```

## A first example

Create a number from a string, an int or a float. Use a string for anything with many digits, because a string never loses precision. The second argument is the scale, which is the number of decimals the number keeps.

```php
use PHPMath\BigNumber\BigNumber;

$a = new BigNumber('12345678901234567890.5', 2);
$b = new BigNumber('0.25');

$sum = $a->add($b);

echo $sum->getValue(); // 12345678901234567890.75
echo $a;               // 12345678901234567890.50
```

Calling `add()` did not change `$a`. It returned a new `BigNumber`. This is true for every operation in the library.

## Where to go next

Start with the core concepts, or jump straight to the topic you need.

<div class="cards"><a href="concepts.md"><strong>Core concepts</strong><span>Immutability, creating values and reading them.</span></a><a href="scale-and-truncation.md"><strong>Scale and truncation</strong><span>How many decimals a number keeps and what happens to the rest.</span></a><a href="arithmetic.md"><strong>Arithmetic</strong><span>Add, divide, modulo, powers and square roots.</span></a><a href="input-formats.md"><strong>Input formats</strong><span>Which strings, ints and floats are accepted.</span></a><a href="base-conversion.md"><strong>Base conversion</strong><span>Convert integers between bases 2 and 36.</span></a><a href="api.md"><strong>API reference</strong><span>Every method with its parameters and errors.</span></a></div>
