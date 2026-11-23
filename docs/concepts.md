---
title: Core concepts
intro: The few ideas you need to use BigNumber well.
group: Getting started
order: 20
---

## Numbers are immutable

`BigNumber` is a `final readonly` class. Once created, a number never changes. Methods such as `add()` or `abs()` return a new instance and leave the original untouched, so you can pass numbers around without defensive copies.

```php
use PHPMath\BigNumber\BigNumber;

$price = new BigNumber('100', 2);
$total = $price->add('25.50');

echo $price; // 100.00
echo $total; // 125.50
```

There is only one kind of number. There is no mutable variant and no flag to switch it on.

## Creating values

The constructor takes a value and an optional scale. The value can be a `string`, an `int`, a `float` or another `BigNumber`. The scale is the number of decimals to keep and defaults to 10. There are no named constructors.

```php
use PHPMath\BigNumber\BigNumber;

echo new BigNumber();                 // 0.0000000000
echo new BigNumber(42);               // 42.0000000000
echo new BigNumber('12345.6789', 2);  // 12345.67
echo new BigNumber(new BigNumber('1.23456', 5), 2); // 1.23
```

The value is normalised when it is created. Normalising means rewriting it in one standard form: no exponent, no leading zeros and exactly as many decimals as the scale. Decimals beyond the scale are cut off, not rounded. See [Scale and truncation](scale-and-truncation.md).

> [!WARNING]
> Pass large or precise numbers as strings. A PHP float has only about 15 to 17 significant digits, so `0.1 + 0.2` is already inexact before the library sees it.

## Reading values

`getValue()` returns the number as a string. The string always has exactly as many decimals as the scale. `getScale()` returns the scale. `toString()` and `__toString()` return the same string as `getValue()`, so a number can be echoed or concatenated.

```php
use PHPMath\BigNumber\BigNumber;

$number = new BigNumber('1.5', 3);

echo $number->getValue();    // 1.500
echo $number->getScale();    // 3
echo $number->toString();    // 1.500
echo "Total: $number";       // Total: 1.500
```

The result is always a string, never a float, so no precision is lost when you read it.

## Operations accept many types

Methods that combine two numbers accept a `string`, an `int`, a `float` or a `BigNumber`. You do not have to wrap raw values first.

```php
use PHPMath\BigNumber\BigNumber;

$a = new BigNumber('10', 2);

echo $a->add(5);                      // 15.00
echo $a->add('0.5');                  // 10.50
echo $a->add(new BigNumber('2.25'));  // 12.25
```

The result has the scale of the number you call the method on. The operand keeps its full precision during the calculation.

## Errors

Invalid input throws an exception from the library, such as `InvalidValueException`. All of them implement the `BigNumberException` marker interface and extend PHP's `InvalidArgumentException`, so one `catch` block can handle every case. See [Errors and exceptions](errors.md) for the full list.

```php
use PHPMath\BigNumber\BigNumber;
use PHPMath\BigNumber\Exception\InvalidValueException;

try {
    new BigNumber('abc');
} catch (InvalidValueException $exception) {
    echo $exception->getMessage(); // Invalid number provided: abc
}
```
