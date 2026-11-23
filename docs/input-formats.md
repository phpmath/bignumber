---
title: Input formats
intro: Which strings, ints and floats the library accepts and how they are read.
group: Guides
order: 50
---

## Accepted values

Every place that takes a number accepts a `string`, an `int`, a `float` or a `BigNumber`. This covers the constructor and the operand of `add()`, `subtract()`, `multiply()`, `divide()` and `mod()`.

```php
use PHPMath\BigNumber\BigNumber;

echo new BigNumber(1234567890);          // 1234567890.0000000000
echo new BigNumber(-5);                  // -5.0000000000
echo new BigNumber(1234567890.125);      // 1234567890.1250000000
echo new BigNumber('1234567890.123');    // 1234567890.1230000000
echo new BigNumber(new BigNumber('12')); // 12.0000000000
```

## Strings

A numeric string has an optional sign, digits, an optional decimal part and an optional exponent. The integer part or the decimal part may be left out, but not both. Exponent notation (such as `1.5e3`) means "times ten to the power". The library expands it into a plain number.

```php
use PHPMath\BigNumber\BigNumber;

echo new BigNumber('+5', 2);      // 5.00
echo new BigNumber('.5', 2);      // 0.50
echo new BigNumber('007', 2);     // 7.00
echo new BigNumber('1.5e3', 2);   // 1500.00
echo new BigNumber('25e-2', 2);   // 0.25
```

These strings are rejected with an `InvalidValueException`.

| String | Why |
|---|---|
| `''` | Empty. |
| `'-'` and `'.'` | No digits. |
| `' 1 '` | Surrounding whitespace is not trimmed. |
| `'1.2.3'` | Two decimal points. |
| `'0x1A'` | Hexadecimal is not supported. See [Base conversion](base-conversion.md). |
| `'abc'` | Not a number. |

## Floats

A float is first written out in full, without an exponent, and then read like a string. Tiny and huge floats work too.

```php
use PHPMath\BigNumber\BigNumber;

echo new BigNumber(1.5E-7);       // 0.0000001500
echo new BigNumber(1.0E+25, 0);   // 10000000000000000000000000
echo new BigNumber(0.1 + 0.2);    // 0.3000000000
```

`NAN` and `INF` are not numbers and throw an `InvalidValueException`.

> [!WARNING]
> A float holds only about 15 to 17 digits. The library cannot add digits that the float never had. Use a string when the exact digits matter.

## Normalising by hand

The conversion is available as `Utils::toNumericString()`. It returns the shortest plain decimal string: no exponent, no leading zeros and no trailing zeros in the decimal part. It does not apply a scale.

```php
use PHPMath\BigNumber\Utils;

echo Utils::toNumericString('007.500'); // 7.5
echo Utils::toNumericString('12.5e2');  // 1250
echo Utils::toNumericString(0.25);      // 0.25
```

A `BigNumber` is accepted too, and gives its value string unchanged.

```php
use PHPMath\BigNumber\BigNumber;
use PHPMath\BigNumber\Utils;

echo Utils::toNumericString(new BigNumber('1.5', 2)); // 1.50
```

`Utils::convertExponentialToString()` turns a float into a plain decimal string. A string is returned as it is.

```php
use PHPMath\BigNumber\Utils;

echo Utils::convertExponentialToString(1.5E-7);   // 0.00000015
echo Utils::convertExponentialToString('1.5E-7'); // 1.5E-7
```
