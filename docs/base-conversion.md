---
title: Base conversion
intro: Convert integers of any size between bases 2 and 36.
group: Guides
order: 60
---

## What a base is

The base of a number is how many different digits it uses. Decimal is base 10, binary is base 2 and hexadecimal is base 16. Bases above 10 use the letters `A` to `Z` for the digits 10 to 35, so the highest base is 36. `Utils::ALPHABET` holds these digits.

`Utils` has two static methods for conversion. Both work on integers of any size, and both accept a string, an int, a float or a `BigNumber`.

## Converting between bases

`Utils::convertBase()` takes the number, the base it is written in and the base you want. The result is a string with uppercase letters.

```php
use PHPMath\BigNumber\Utils;

echo Utils::convertBase('255', 10, 16);   // FF
echo Utils::convertBase('1010', 2, 10);   // 10
echo Utils::convertBase('-255', 10, 16);  // -FF
echo Utils::convertBase('1208925819614629174706175', 10, 16); // FFFFFFFFFFFFFFFFFFFF
```

The input letters can be uppercase or lowercase.

## Converting to base 10

`Utils::convertToBase10()` converts from any base to decimal. It takes the number and the base it is written in.

```php
use PHPMath\BigNumber\Utils;

echo Utils::convertToBase10('ff', 16); // 255
```

## Fractions are discarded

Only integers are converted. A fractional part is thrown away, not rounded.

```php
use PHPMath\BigNumber\Utils;
use PHPMath\BigNumber\BigNumber;

echo Utils::convertToBase10('ff.8', 16);                       // 255
echo Utils::convertBase(new BigNumber('255.9'), 10, 2);        // 11111111
```

## Invalid input

A base outside 2 to 36 throws an `InvalidBaseException`. A digit that does not exist in the source base throws an `InvalidValueException`.

```php
use PHPMath\BigNumber\Exception\InvalidBaseException;
use PHPMath\BigNumber\Exception\InvalidValueException;
use PHPMath\BigNumber\Utils;

try {
    Utils::convertToBase10('2', 2);
} catch (InvalidValueException $exception) {
    echo $exception->getMessage(); // The digit 2 in the number 2 is an invalid digit for base-2.
}

try {
    Utils::convertBase('1', 10, 37);
} catch (InvalidBaseException $exception) {
    echo $exception->getMessage(); // Base 37 is unsupported, should be between 2 and 36.
}
```
