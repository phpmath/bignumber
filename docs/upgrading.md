---
title: Upgrading from 1.x
intro: This version makes BigNumber immutable and renames the namespace.
group: Reference
order: 90
---

## Summary of changes

This version is a breaking release. These are the changes that affect your code.

- `BigNumber` is now immutable. The mutable flag is removed.
- `setValue()`, `setScale()` and `isMutable()` are removed.
- `withScale()` is added. It returns a copy with another scale, and `round()` is added to round to a scale.
- Errors now throw specific exceptions. All of them extend `InvalidArgumentException`, so existing `catch` blocks keep working. They also implement the `BigNumberException` marker interface.
- `Utils::getPlainNumber()` is removed. Use `Utils::toNumericString()`, which does the same and also accepts a `BigNumber`.
- `Utils::multiply()` is removed. Use `(new BigNumber($left, $scale))->multiply($right)`.
- `pow()` now accepts a negative integer string such as `'-2'`, and `divide()` and `mod()` only reject a divisor that is exactly zero.
- Several bugs were fixed (for example in `mod()`, exponent notation and base conversion), so results for those inputs can differ.
- The namespace changes from `PHP\Math\BigNumber` to `PHPMath\BigNumber`.
- PHP 8.4 or newer is required.

## Step by step

Follow these steps to move an existing project from 1.x.

### 1. Update the requirements and namespace

Make sure you run PHP 8.4 or newer, then update the imports.

```php
// before
use PHP\Math\BigNumber\BigNumber;

// after
use PHPMath\BigNumber\BigNumber;
```

### 2. Remove the mutable flag

In 1.x the third constructor argument made a number immutable, and numbers were mutable unless you passed it. Delete that argument wherever you create a number. Every number is immutable now, and `isMutable()` no longer exists, so remove any code that checks it.

### 3. Assign results instead of relying on in-place changes

In 1.x a mutable number changed itself when you called a method on it. Now every method returns a new number, so assign the result.

```php
// before
$number = new BigNumber('10');
$number->add('5');

// after
$number = new BigNumber('10');
$number = $number->add('5');
```

### 4. Replace setValue() and setScale()

`setValue()` changed the value of an existing number. Create a new number instead. `setScale()` is replaced by `withScale()`, which returns a copy.

```php
// before
$number->setValue('42');
$number->setScale(2);

// after
$number = new BigNumber('42', 2);
$other = $number->withScale(4);
```

### 5. Replace removed Utils methods

`Utils::getPlainNumber()` and `Utils::multiply()` no longer exist. `Utils::toNumericString()` replaces the first, and `BigNumber::multiply()` the second.

```php
// before
$plain = Utils::getPlainNumber($value);
$product = Utils::multiply($left, $right, 2);

// after
$plain = Utils::toNumericString($value);
$product = (new BigNumber($left, 2))->multiply($right);
```

### 6. Re-check edge cases

Truncation to the scale did not change: 1.x already used bcmath, which cuts digits off instead of rounding them, see [Scale and truncation](scale-and-truncation.md). What did change are bug fixes, so re-run your tests for `mod()`, numbers written in exponent notation such as `1.5e3`, and base conversion with the `Utils` class. 2.x still needs the `bcmath` extension.
