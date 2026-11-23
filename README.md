# bignumber

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![CI][ico-ci]][link-ci]
[![Total Downloads][ico-downloads]][link-downloads]

A PHP library to work with big numbers. This library makes use of the BCMath extension to do its calculations.
Every `BigNumber` is an immutable value object: operations never change the instance, they return a new one.

## Documentation

The full documentation is at https://phpmath.github.io/bignumber/. Every change is listed in the [changelog](CHANGELOG.md) and every release on the [releases page](https://github.com/phpmath/bignumber/releases).

## Install

```bash
composer require phpmath/bignumber
```

## Requirements

- PHP 8.4 or newer
- The `bcmath` extension

## Usage

```php
use PHPMath\BigNumber\BigNumber;

$a = new BigNumber('12345678901234567890.5', 2);
$b = new BigNumber('0.25');

$sum = $a->add($b);

echo $sum->getValue(); // 12345678901234567890.75
echo $a; // 12345678901234567890.50 (unchanged)
```

The scale (number of decimals, default 10) is set on construction. Results are truncated, not rounded, to the scale (use `round()` to round)
of the number the operation is called on. Use `withScale()` to get a copy with another scale.

## Features

- `add()`, `subtract()`, `multiply()`, `divide()`, `mod()`, `pow()`, `sqrt()` and `abs()`.
- Operands can be strings, integers, floats (also exponential notation) or other `BigNumber` instances.
- Specific exceptions, all implementing `BigNumberException`.
- `Utils::convertBase()` and `Utils::convertToBase10()` convert integers of any size between bases 2 and 36.

## Development

```bash
composer test
composer test-coverage
composer analyse
composer check-style
composer fix-style
```

## Contributing

All contributions are welcome. Open an issue or a pull request on GitHub. Please follow the coding standard and add tests.

## Security

If you discover a security issue, please create an issue in the issue tracker.

## Credits

- [Walter Tamboer](https://github.com/waltertamboer)
- [All contributors](https://github.com/phpmath/bignumber/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/phpmath/bignumber.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-ci]: https://img.shields.io/github/actions/workflow/status/phpmath/bignumber/ci.yml?branch=master&style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phpmath/bignumber.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/phpmath/bignumber
[link-ci]: https://github.com/phpmath/bignumber/actions/workflows/ci.yml
[link-downloads]: https://packagist.org/packages/phpmath/bignumber/stats
