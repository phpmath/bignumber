---
title: Arithmetic
intro: Add, subtract, multiply and divide, then modulo, powers and square roots.
group: Guides
order: 40
---

## The four operations

`add()`, `subtract()` and `multiply()` take a value and return the result as a new `BigNumber`. The value can be a string, an int, a float or another `BigNumber`. The result is truncated to the scale of the number you call the method on.

```php
use PHPMath\BigNumber\BigNumber;

$a = new BigNumber('12345678901234567890.5', 2);

echo $a->add('0.25');       // 12345678901234567890.75
echo $a->subtract('0.75');  // 12345678901234567889.75
echo $a->multiply(2);       // 24691357802469135781.00
```

Whole numbers can be any size. There is no overflow, because the numbers are strings inside.

## Division

`divide()` divides by the given value. The result is truncated to the scale, toward zero.

```php
use PHPMath\BigNumber\BigNumber;

$a = new BigNumber('10', 4);

echo $a->divide(3);                          // 3.3333
echo $a->multiply(-1)->divide(3);            // -3.3333
echo (new BigNumber('7', 0))->divide(2);     // 3
```

The divisor is read with all its digits, so a tiny divisor gives a large result instead of an error.

```php
use PHPMath\BigNumber\BigNumber;

echo (new BigNumber('1'))->divide('1e-28'); // 10000000000000000000000000000.0000000000
echo (new BigNumber('1'))->divide('1e30');  // 0.0000000000
```

> [!WARNING]
> Dividing by zero is an error. `divide()` throws a `DivisionByZeroException` when the divisor is zero. A divisor counts as zero only when it really is zero, so a tiny divisor such as `1e-28` works. See [Errors and exceptions](errors.md).

## Modulo

`mod()` returns the remainder of a division. The result takes the sign of the number you call it on, so it can be negative. The divisor can have decimals.

```php
use PHPMath\BigNumber\BigNumber;

echo (new BigNumber('10'))->mod(3);       // 1.0000000000
echo (new BigNumber('5'))->mod('1.5');    // 0.5000000000
echo (new BigNumber('-10.5', 2))->mod(3); // -1.50
```

A zero divisor throws a `DivisionByZeroException`. As with `divide()`, a tiny divisor is used with all its digits.

```php
use PHPMath\BigNumber\BigNumber;

echo (new BigNumber('1', 30))->mod('3e-28'); // 0.000000000000000000000000000100
```

## Powers

`pow()` raises the number to an integer exponent. The exponent is an int or a string that holds an integer. A fractional exponent such as `'1.5'` is not allowed. For a root, use `sqrt()`.

```php
use PHPMath\BigNumber\BigNumber;

echo (new BigNumber('2'))->pow(10);         // 1024.0000000000
echo (new BigNumber('2'))->pow('3');        // 8.0000000000
echo (new BigNumber('1.5', 2))->pow(3);     // 3.37
echo (new BigNumber('2', 2))->pow(-2);      // 0.25
echo (new BigNumber('2', 2))->pow('-2');    // 0.25
echo (new BigNumber('123456789', 0))->pow(3); // 1881676371789154860897069
```

`1.5` to the power 3 is exactly `3.375`, which truncates to `3.37`.

> [!NOTE]
> A negative exponent works as an int (`pow(-2)`) and as a string (`pow('-2')`), with the same result. A string must still hold an integer, so `pow('-1.5')` throws an `InvalidExponentException`.

## Square roots

`sqrt()` returns the square root, truncated to the scale. Taking the root of a negative number throws a `NegativeValueException`. Zero is fine.

```php
use PHPMath\BigNumber\BigNumber;

echo (new BigNumber('2', 20))->sqrt(); // 1.41421356237309504880
echo (new BigNumber('10', 0))->sqrt(); // 3
```

## Absolute value

`abs()` returns the number without its sign.

```php
use PHPMath\BigNumber\BigNumber;

echo (new BigNumber('-3.5', 2))->abs(); // 3.50
```

## Chaining

Every method returns a `BigNumber`, so calls can be chained. Each step truncates to the scale.

```php
use PHPMath\BigNumber\BigNumber;

echo (new BigNumber('0.1', 1))->add('0.2')->multiply(3); // 0.9
```
