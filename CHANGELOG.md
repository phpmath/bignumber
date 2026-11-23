# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.0] - 2026-11-23

### Added

- `withScale()` and `round()`, which rounds half away from zero.
- Specific exceptions that implement the marker interface `BigNumberException`.
- A documentation site at https://phpmath.github.io/bignumber/.

### Changed

- `BigNumber` is immutable, the namespace is now `PHPMath\BigNumber`.
- Requires PHP 8.4 or newer and the `bcmath` extension.
- `pow()` accepts negative integer strings like negative integers.
- `divide()` and `mod()` treat a divisor as zero only when it really is zero.

### Removed

- The mutable flag, `setValue()`, `setScale()` and `isMutable()`.
- `Utils::getPlainNumber()` and `Utils::multiply()`.

### Fixed

- Calculation bugs in `mod()`, numbers in exponent notation and base conversion.

Earlier versions are described on the [releases page](https://github.com/phpmath/bignumber/releases).

[Unreleased]: https://github.com/phpmath/bignumber/compare/2.0.0...HEAD
[2.0.0]: https://github.com/phpmath/bignumber/compare/1.2.0...2.0.0
