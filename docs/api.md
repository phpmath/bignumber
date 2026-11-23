---
title: API reference
intro: Every public method of BigNumber and Utils, grouped by purpose.
group: Reference
order: 70
layout: reference
---

Every `BigNumber` method that returns `self` returns a new instance. The class is `PHPMath\BigNumber\BigNumber`. The helper class is `PHPMath\BigNumber\Utils`. All thrown exceptions implement `PHPMath\BigNumber\Exception\BigNumberException` and extend PHP's `InvalidArgumentException`, see [Errors and exceptions](errors.md). A value is a `string|int|float|BigNumber`. The library has no named constructors.

## Construction and output

Create a number, read its value and scale, and change the scale.

### __construct()

```php
public function __construct(string|int|float|self $value = 0, private int $scale = 10)
```

Creates a number. The value is normalised and truncated to the scale.

- **Parameters:** `$value` the value, `$scale` the number of decimals to keep (0 or higher)
- **Throws:** `InvalidValueException` if the value is not numeric, `InvalidScaleException` if the scale is negative

### getValue()

```php
public function getValue(): string
```

Returns the number as a string with exactly as many decimals as the scale.

- **Returns:** `numeric-string`

### getScale()

```php
public function getScale(): int
```

Returns the scale of the number.

- **Returns:** `int`

### withScale()

```php
public function withScale(int $scale): self
```

Returns a copy of the number with another scale. A smaller scale truncates decimals.

- **Parameters:** `$scale` the scale of the new number
- **Returns:** `BigNumber`
- **Throws:** `InvalidScaleException` if the scale is negative

### round()

```php
public function round(int $scale): self
```

Returns a copy of the number, rounded to the given scale. A half rounds away from zero, like PHP's `round()`. Unlike `withScale()`, which cuts digits off, this looks at the digits that are removed. A scale that is equal to or larger than the current scale only changes the scale.

- **Parameters:** `$scale` the scale of the new number
- **Returns:** `BigNumber`
- **Throws:** `InvalidScaleException` if the scale is negative

### toString()

```php
public function toString(): string
```

Returns the same string as `getValue()`.

- **Returns:** `string`

### __toString()

```php
public function __toString(): string
```

Returns the same string as `getValue()`. This makes the class `Stringable`.

- **Returns:** `string`

## Arithmetic

Operations that return a new number, truncated to the scale of the number they are called on.

### abs()

```php
public function abs(): self
```

Returns the absolute value.

- **Returns:** `BigNumber`

### add()

```php
public function add(string|int|float|self $value): self
```

Adds a value.

- **Parameters:** `$value` the value to add
- **Returns:** `BigNumber`
- **Throws:** `InvalidValueException` if the value is not numeric

### subtract()

```php
public function subtract(string|int|float|self $value): self
```

Subtracts a value.

- **Parameters:** `$value` the value to subtract
- **Returns:** `BigNumber`
- **Throws:** `InvalidValueException` if the value is not numeric

### multiply()

```php
public function multiply(string|int|float|self $value): self
```

Multiplies by a value.

- **Parameters:** `$value` the value to multiply with
- **Returns:** `BigNumber`
- **Throws:** `InvalidValueException` if the value is not numeric

### divide()

```php
public function divide(string|int|float|self $value): self
```

Divides by a value. The result is truncated toward zero.

- **Parameters:** `$value` the divisor
- **Returns:** `BigNumber`
- **Throws:** `InvalidValueException` if the value is not numeric, `DivisionByZeroException` if the divisor is zero

### mod()

```php
public function mod(string|int|float|self $value): self
```

Returns the remainder of a division. The result has the sign of the dividend.

- **Parameters:** `$value` the divisor
- **Returns:** `BigNumber`
- **Throws:** `InvalidValueException` if the value is not numeric, `DivisionByZeroException` if the divisor is zero

### pow()

```php
public function pow(int|string $exponent): self
```

Raises the number to an integer power.

- **Parameters:** `$exponent` an int, or a string of digits. A negative exponent is accepted as an int or as a string, with the same result.
- **Returns:** `BigNumber`
- **Throws:** `InvalidExponentException` if the exponent is not an integer

### sqrt()

```php
public function sqrt(): self
```

Returns the square root.

- **Returns:** `BigNumber`
- **Throws:** `NegativeValueException` if the number is negative

## Utils: conversion

Static helpers that convert values to plain strings and integers between bases.

### Utils::toNumericString()

```php
public static function toNumericString(string|int|float|BigNumber $value): string
```

Converts a value to a plain decimal string without exponent, leading zeros or trailing decimal zeros. A `BigNumber` gives its value string unchanged.

- **Parameters:** `$value` the value to convert
- **Returns:** `numeric-string`
- **Throws:** `InvalidValueException` if the value is not numeric

### Utils::convertExponentialToString()

```php
public static function convertExponentialToString(float|string $value): string
```

Writes a float as a plain decimal string without exponent. A string is returned unchanged.

- **Parameters:** `$value` the float or string
- **Returns:** `string`

### Utils::convertToBase10()

```php
public static function convertToBase10(string|int|float|BigNumber $number, int $fromBase): string
```

Converts an integer from another base to base 10. A fractional part is discarded.

- **Parameters:** `$number` the number, `$fromBase` the base it is written in (2 to 36)
- **Returns:** `string`
- **Throws:** `InvalidBaseException` if the base is out of range, `InvalidValueException` if the number has a digit that is invalid for the base

### Utils::convertBase()

```php
public static function convertBase(string|int|float|BigNumber $number, int $fromBase, int $toBase): string
```

Converts an integer from one base to another. A fractional part is discarded. Letters in the result are uppercase.

- **Parameters:** `$number` the number, `$fromBase` the source base, `$toBase` the target base (both 2 to 36)
- **Returns:** `string`
- **Throws:** `InvalidBaseException` if a base is out of range, `InvalidValueException` if the number has a digit that is invalid for the source base

## Utils: other

A constant with the digits of the supported bases.

### Utils::ALPHABET

```php
public const string ALPHABET = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
```

The digits used for bases 2 to 36.

- **Returns:** `string`
