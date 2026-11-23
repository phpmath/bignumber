---
title: Errors and exceptions
intro: What can go wrong and how to catch it.
group: Reference
order: 80
---

## Library exceptions

Every exception the library throws implements the marker interface `PHPMath\BigNumber\Exception\BigNumberException`, so one `catch` block handles all of them. Each exception also extends PHP's `InvalidArgumentException`, which says that an argument has an invalid value. Catch a specific class when you can recover from one kind of error. Read `getMessage()` for the details.

| Exception | Extends | Thrown when |
|---|---|---|
| `PHPMath\BigNumber\Exception\InvalidValueException` | `InvalidArgumentException` | A value is not numeric, or a digit is not valid for the base. |
| `PHPMath\BigNumber\Exception\InvalidScaleException` | `InvalidArgumentException` | A scale is negative. |
| `PHPMath\BigNumber\Exception\InvalidExponentException` | `InvalidArgumentException` | An exponent is not an integer. |
| `PHPMath\BigNumber\Exception\InvalidBaseException` | `InvalidArgumentException` | A number base is below 2 or above 36. |
| `PHPMath\BigNumber\Exception\DivisionByZeroException` | `InvalidArgumentException` | `divide()` or `mod()` gets a zero divisor. |
| `PHPMath\BigNumber\Exception\NegativeValueException` | `InvalidArgumentException` | `sqrt()` is called on a negative number. |

```php
use PHPMath\BigNumber\BigNumber;
use PHPMath\BigNumber\Exception\BigNumberException;

try {
    (new BigNumber('1'))->divide(0);
} catch (BigNumberException $exception) {
    echo $exception->getMessage(); // Cannot divide by zero.
}
```

## When each exception is thrown

This table lists every case where a method rejects its input, with the message it gives.

| Method | Exception | Condition | Message |
|---|---|---|---|
| `new BigNumber()`, `add()`, `subtract()`, `multiply()`, `divide()`, `mod()`, `Utils::toNumericString()` | `InvalidValueException` | The value is not numeric. | `Invalid number provided: abc` |
| `new BigNumber()`, `withScale()`, `round()` | `InvalidScaleException` | The scale is negative. | `Invalid scale "-1" provided. Should be 0 or higher.` |
| `divide()` | `DivisionByZeroException` | The divisor is zero. | `Cannot divide by zero.` |
| `mod()` | `DivisionByZeroException` | The divisor is zero. | `Cannot perform a modulo operation with zero.` |
| `pow()` | `InvalidExponentException` | The exponent is not an integer. | `Invalid exponent "1.5" provided. Only integers are allowed.` |
| `sqrt()` | `NegativeValueException` | The number is negative. | `Cannot calculate the square root of a negative number.` |
| `Utils::convertBase()`, `Utils::convertToBase10()` | `InvalidBaseException` | A base is below 2 or above 36. | `Base 37 is unsupported, should be between 2 and 36.` |
| `Utils::convertBase()`, `Utils::convertToBase10()` | `InvalidValueException` | A digit is not valid in the source base. | `The digit 2 in the number 2 is an invalid digit for base-2.` |

A number is "not numeric" when it is an empty string, has whitespace, has no digits, has two decimal points, is `NAN` or `INF`, or contains other characters. See [Input formats](input-formats.md).

> [!NOTE]
> A divisor counts as zero only when it is exactly zero, whatever its scale or notation. `0`, `0.000` and `0e5` throw, while a tiny divisor such as `1e-28` does not.

## Handling untrusted input

Wrap the constructor when the value comes from a user.

```php
use PHPMath\BigNumber\BigNumber;
use PHPMath\BigNumber\Exception\InvalidValueException;

try {
    $amount = new BigNumber($_POST['amount'], 2);
} catch (InvalidValueException) {
    // not a number
}
```
