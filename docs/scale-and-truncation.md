---
title: Scale and truncation
intro: How many decimals a number keeps and what happens to the rest.
group: Guides
order: 30
---

## What the scale is

The scale is the number of digits after the decimal point that a number keeps. Every `BigNumber` has one. It defaults to 10 and you set it as the second constructor argument. It must be 0 or higher.

```php
use PHPMath\BigNumber\BigNumber;

$a = new BigNumber('10', 2);
$b = new BigNumber('10');

echo $a;             // 10.00
echo $b;             // 10.0000000000
echo $a->getScale(); // 2
echo $b->getScale(); // 10
```

A scale of 0 gives whole numbers. A negative scale throws an `InvalidScaleException`.

## Truncation, not rounding

Truncating means cutting off digits without changing the digits that stay. Rounding would look at the cut digits and sometimes add one. Operations and `withScale()` never round. They truncate, toward zero, for both positive and negative numbers. Use `round()` when you want rounding, see below.

```php
use PHPMath\BigNumber\BigNumber;

echo new BigNumber('2.999', 2);   // 2.99
echo new BigNumber('-1.999', 2);  // -1.99
```

A negative value that truncates to zero becomes plain zero, without a minus sign.

```php
use PHPMath\BigNumber\BigNumber;

echo new BigNumber('-0.001', 2); // 0.00
```

## Rounding

`round()` returns a copy of the number with a smaller scale, and looks at the digits it removes. A half rounds away from zero, so `2.5` becomes `3` and `-2.5` becomes `-3`, like PHP's `round()`. `withScale()` cuts the same digits off instead.

```php
use PHPMath\BigNumber\BigNumber;

$number = new BigNumber('2.345', 3);

echo $number->round(2);                         // 2.35
echo $number->withScale(2);                     // 2.34
echo (new BigNumber('-2.345', 3))->round(2);    // -2.35
echo (new BigNumber('2.5', 1))->round(0);       // 3
echo (new BigNumber('9.995', 3))->round(2);     // 10.00
```

A scale that is equal to or larger than the current scale changes nothing but the scale. A negative scale throws an `InvalidScaleException`. The usual pattern is to calculate with a large scale, then round once at the end.

```php
use PHPMath\BigNumber\BigNumber;

$third = (new BigNumber('2', 2))->divide(3);

echo $third;             // 0.66
echo $third->round(1);   // 0.7
```

## The scale of a result

Every operation truncates its result to the scale of the number it is called on. The scale of the operand does not matter for the result.

```php
use PHPMath\BigNumber\BigNumber;

$x = new BigNumber('10', 4);

echo $x->divide(3);                   // 3.3333
echo (new BigNumber('1', 0))->divide(3); // 0
echo (new BigNumber('1.5', 2))->multiply('0.333'); // 0.49
```

The last line shows that the operand `0.333` is used with all its digits. The exact product is `0.4995`, and the result is cut to two decimals.

Only the result is truncated, never the operands. A string, int or float operand is used with all its digits, so the calculation is done exactly and the cut happens once at the end. This can give a result that looks off by one when you compare it with a calculation on cut operands.

```php
use PHPMath\BigNumber\BigNumber;

echo (new BigNumber('0.5', 2))->subtract('0.999'); // -0.49
echo (new BigNumber('0.5', 2))->subtract('0.009'); // 0.49
```

The exact result of `0.5 - 0.999` is `-0.499`, which truncates to `-0.49`. It is not `-0.50` (rounding), and it is not the difference of the cut operands. In the same way, `0.5 - 0.009` is `0.491`, which truncates to `0.49`, and not `0.50`. A `BigNumber` operand is different: it was already cut to its own scale when it was created, so its extra digits are gone.

```php
use PHPMath\BigNumber\BigNumber;

echo (new BigNumber('0.5', 2))->subtract(new BigNumber('0.009', 2)); // 0.50
```

When two numbers have different scales, the one on the left decides.

```php
use PHPMath\BigNumber\BigNumber;

$low = new BigNumber('1.5', 1);
$high = new BigNumber('1.5', 5);
$other = new BigNumber('0.123', 3);

echo $low->add($other);  // 1.6
echo $high->add($other); // 1.62300
```

> [!NOTE]
> Because of truncation, doing several operations in a row can lose a little precision at each step. Use a larger scale for the calculation and cut it down at the end with `withScale()`.

## Changing the scale

`withScale()` returns a copy of the number with another scale. A smaller scale cuts decimals. A larger scale adds zeros, but it cannot bring back digits that were already cut.

```php
use PHPMath\BigNumber\BigNumber;

$precise = new BigNumber('1.23456', 5);

echo $precise->withScale(2);                  // 1.23
echo $precise->withScale(2)->withScale(5);    // 1.23000
echo (new BigNumber('1.5', 1))->withScale(4); // 1.5000
```

The original number is not changed.

## Equal values

The value string always has the same number of decimals as the scale, so two numbers with the same value and the same scale give the same string. You can compare them with `===`. There are no comparison methods in this version.

```php
use PHPMath\BigNumber\BigNumber;

var_dump((new BigNumber('1.0'))->getValue() === (new BigNumber('1'))->getValue()); // bool(true)
```
