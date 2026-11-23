<?php
/**
 * phpmath / bignumber (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\BigNumber;

use PHPMath\BigNumber\Exception\DivisionByZeroException;
use PHPMath\BigNumber\Exception\InvalidExponentException;
use PHPMath\BigNumber\Exception\InvalidScaleException;
use PHPMath\BigNumber\Exception\InvalidValueException;
use PHPMath\BigNumber\Exception\NegativeValueException;
use Stringable;

use function assert;
use function bcadd;
use function bccomp;
use function bcdiv;
use function bcmod;
use function bcmul;
use function bcpow;
use function bcsqrt;
use function bcsub;
use function ctype_digit;
use function is_numeric;
use function ltrim;
use function sprintf;
use function str_repeat;
use function str_starts_with;
use function strlen;
use function strpos;

/**
 * An immutable big number value. Every operation returns a new instance. Results are truncated (not rounded)
 * to the scale of the number the operation is invoked on. Use round() to round explicitly.
 */
final readonly class BigNumber implements Stringable
{
    /**
     * The value, normalized to the scale.
     */
    /** @var numeric-string */
    private string $value;

    /**
     * Initializes a new instance of this class.
     *
     * @param string|int|float|self $value The value to set.
     * @param int $scale The number of decimals to keep.
     *
     * @throws InvalidValueException Thrown when the value is not numeric.
     * @throws InvalidScaleException Thrown when the scale is negative.
     */
    public function __construct(string|int|float|self $value = 0, private int $scale = 10)
    {
        if ($scale < 0) {
            throw new InvalidScaleException(sprintf('Invalid scale "%d" provided. Should be 0 or higher.', $scale));
        }

        $this->value = bcadd('0', Utils::toNumericString($value), $scale);
    }

    /**
     * Gets the value of the big number.
     *
     * @return numeric-string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Gets the scale of this number.
     */
    public function getScale(): int
    {
        return $this->scale;
    }

    /**
     * Returns a copy of this number with the given scale.
     *
     * @param int $scale The scale of the new number.
     *
     * @throws InvalidScaleException Thrown when the scale is negative.
     */
    public function withScale(int $scale): self
    {
        return new self($this->value, $scale);
    }

    /**
     * Returns a copy of this number, rounded to the given scale. A half rounds away from zero, like PHP's round().
     *
     * Unlike withScale(), which cuts digits off, this looks at the digits that are removed. A scale that is equal to
     * or larger than the current scale changes nothing but the scale.
     *
     * @param int $scale The scale of the new number.
     *
     * @throws InvalidScaleException Thrown when the scale is negative.
     */
    public function round(int $scale): self
    {
        if ($scale < 0) {
            throw new InvalidScaleException(sprintf('Invalid scale "%d" provided. Should be 0 or higher.', $scale));
        }

        if ($scale >= $this->scale) {
            return new self($this->value, $scale);
        }

        // Adding half of the last kept digit and then cutting off the rest rounds a half away from zero.
        $half = '0.' . str_repeat('0', $scale) . '5';
        $addend = str_starts_with($this->value, '-') ? '-' . $half : $half;
        assert(is_numeric($addend));

        return new self(bcadd($this->value, $addend, $scale), $scale);
    }

    /**
     * Returns the absolute value.
     */
    public function abs(): self
    {
        return new self(ltrim($this->value, '-'), $this->scale);
    }

    /**
     * Adds the given value to this value.
     *
     * @param string|int|float|self $value The value to add.
     */
    public function add(string|int|float|self $value): self
    {
        return new self(bcadd($this->value, Utils::toNumericString($value), $this->scale), $this->scale);
    }

    /**
     * Subtracts the given value from this value.
     *
     * @param string|int|float|self $value The value to subtract.
     */
    public function subtract(string|int|float|self $value): self
    {
        return new self(bcsub($this->value, Utils::toNumericString($value), $this->scale), $this->scale);
    }

    /**
     * Multiplies this value with the given value.
     *
     * @param string|int|float|self $value The value to multiply with.
     */
    public function multiply(string|int|float|self $value): self
    {
        return new self(bcmul($this->value, Utils::toNumericString($value), $this->scale), $this->scale);
    }

    /**
     * Divides this value by the given value.
     *
     * @param string|int|float|self $value The value to divide by.
     *
     * @throws DivisionByZeroException Thrown when dividing by zero.
     */
    public function divide(string|int|float|self $value): self
    {
        $divisor = Utils::toNumericString($value);
        if (self::isZero($divisor)) {
            throw new DivisionByZeroException('Cannot divide by zero.');
        }

        return new self(bcdiv($this->value, $divisor, $this->scale), $this->scale);
    }

    /**
     * Performs a modulo operation with the given value.
     *
     * @param string|int|float|self $value The divisor.
     *
     * @throws DivisionByZeroException Thrown when the divisor is zero.
     */
    public function mod(string|int|float|self $value): self
    {
        $divisor = Utils::toNumericString($value);
        if (self::isZero($divisor)) {
            throw new DivisionByZeroException('Cannot perform a modulo operation with zero.');
        }

        return new self(bcmod($this->value, $divisor, $this->scale), $this->scale);
    }

    /**
     * Raises this value to the given power.
     *
     * @param int|string $exponent The exponent. Should be an integer (or an int-string, which may be negative).
     *
     * @throws InvalidExponentException Thrown when the exponent is not an integer.
     */
    public function pow(int|string $exponent): self
    {
        $digits = ltrim((string)$exponent, '-');
        if (strlen((string)$exponent) - strlen($digits) > 1 || $digits === '' || !ctype_digit($digits)) {
            throw new InvalidExponentException(sprintf(
                'Invalid exponent "%s" provided. Only integers are allowed.',
                $exponent,
            ));
        }

        $power = (string)$exponent;
        assert(is_numeric($power));

        return new self(bcpow($this->value, $power, $this->scale), $this->scale);
    }

    /**
     * Calculates the square root.
     *
     * @throws NegativeValueException Thrown when the value is negative.
     */
    public function sqrt(): self
    {
        if (str_starts_with($this->value, '-') && bccomp($this->value, '0', $this->scale) !== 0) {
            throw new NegativeValueException('Cannot calculate the square root of a negative number.');
        }

        return new self(bcsqrt($this->value, $this->scale), $this->scale);
    }

    /**
     * Converts this number to a string.
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * Converts this number to a string.
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * Checks whether a plain numeric string is exactly zero, looking at all its digits.
     *
     * @param numeric-string $number A plain decimal string, as returned by Utils::toNumericString().
     */
    private static function isZero(string $number): bool
    {
        $dot = strpos($number, '.');
        $decimals = $dot === false ? 0 : strlen($number) - $dot - 1;

        return bccomp($number, '0', $decimals) === 0;
    }
}
