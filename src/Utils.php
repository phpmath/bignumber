<?php
/**
 * phpmath / bignumber (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\BigNumber;

use PHPMath\BigNumber\Exception\InvalidBaseException;
use PHPMath\BigNumber\Exception\InvalidValueException;

use function abs;
use function assert;
use function bcadd;
use function bcdiv;
use function bcmod;
use function bcmul;
use function explode;
use function is_float;
use function is_int;
use function is_numeric;
use function is_string;
use function ltrim;
use function preg_match;
use function rtrim;
use function sprintf;
use function str_contains;
use function str_repeat;
use function strlen;
use function strpos;
use function strtoupper;
use function substr;

/**
 * A utility class.
 */
final class Utils
{
    public const string ALPHABET = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    private const string NUMERIC_PATTERN = '/^(?<sign>[+-]?)(?<int>\d*)(?:\.(?<frac>\d*))?(?:[eE](?<exp>[+-]?\d+))?$/';

    /**
     * Converts the given value to a plain decimal string (without exponent, full precision), as accepted by bcmath.
     *
     * @param string|int|float|BigNumber $value The value to convert.
     *
     * @return numeric-string
     *
     * @throws InvalidValueException Thrown when the value is not numeric.
     */
    public static function toNumericString(string|int|float|BigNumber $value): string
    {
        if ($value instanceof BigNumber) {
            return $value->getValue();
        }

        if (is_int($value)) {
            return (string)$value;
        }

        $string = is_float($value) ? self::convertExponentialToString($value) : $value;

        if (
            preg_match(self::NUMERIC_PATTERN, $string, $m) !== 1
            || ($m['int'] === '' && ($m['frac'] ?? '') === '')
        ) {
            throw new InvalidValueException('Invalid number provided: ' . $string);
        }

        $int = $m['int'] === '' ? '0' : $m['int'];
        $frac = $m['frac'] ?? '';
        $exp = (int)($m['exp'] ?? 0);

        if ($exp > 0) {
            $frac .= str_repeat('0', $exp);
            $int .= substr($frac, 0, $exp);
            $frac = substr($frac, $exp);
        } elseif ($exp < 0) {
            $shift = -$exp;
            $int = str_repeat('0', $shift) . $int;
            $frac = substr($int, -$shift) . $frac;
            $int = substr($int, 0, -$shift);
        }

        $int = ltrim($int, '0');
        $int = $int === '' ? '0' : $int;
        $frac = rtrim($frac, '0');
        $sign = $m['sign'] === '-' ? '-' : '';

        $result = $sign . $int . ($frac === '' ? '' : '.' . $frac);
        assert(is_numeric($result));

        return $result;
    }

    /**
     * Converts the provided integer from an arbitrary base to a base 10 number. A fractional part is discarded.
     *
     * @param string|int|float|BigNumber $number   The number to convert.
     * @param int $fromBase The base to convert the number from (2 to 36).
     *
     * @throws InvalidBaseException Thrown when the base is out of range.
     * @throws InvalidValueException Thrown when the number has an invalid digit.
     */
    public static function convertToBase10(string|int|float|BigNumber $number, int $fromBase): string
    {
        self::assertBase($fromBase);

        $plain = is_string($number) ? $number : self::toNumericString($number);
        $plain = self::integerPart($plain);
        if (ltrim($plain, '-') === '') {
            throw new InvalidValueException('Invalid number provided: ' . $plain);
        }

        $sign = $plain[0] === '-' ? '-' : '';
        $digits = strtoupper(ltrim($plain, '-'));

        $result = '0';
        for ($i = 0, $len = strlen($digits); $i < $len; $i++) {
            $index = strpos(self::ALPHABET, $digits[$i]);

            if ($index === false || $index >= $fromBase) {
                throw new InvalidValueException(sprintf(
                    'The digit %s in the number %s is an invalid digit for base-%d.',
                    $digits[$i],
                    $plain,
                    $fromBase,
                ));
            }

            $result = bcadd(bcmul($result, (string)$fromBase), (string)$index);
        }

        return $result === '0' ? $result : $sign . $result;
    }

    /**
     * Converts the provided integer from an arbitrary base to another arbitrary base (2 to 36).
     * A fractional part is discarded.
     *
     * @param string|int|float|BigNumber $number   The number to convert.
     * @param int $fromBase The base to convert the number from.
     * @param int $toBase   The base to convert the number to.
     *
     * @throws InvalidBaseException Thrown when a base is out of range.
     * @throws InvalidValueException Thrown when the number has an invalid digit.
     */
    public static function convertBase(string|int|float|BigNumber $number, int $fromBase, int $toBase): string
    {
        self::assertBase($fromBase);
        self::assertBase($toBase);

        $decimal = self::convertToBase10($number, $fromBase);
        if ($toBase === 10) {
            return $decimal;
        }

        $sign = $decimal[0] === '-' ? '-' : '';
        $decimal = ltrim($decimal, '-');

        $result = '';
        do {
            $result = self::ALPHABET[(int)bcmod($decimal, (string)$toBase)] . $result;
            $decimal = bcdiv($decimal, (string)$toBase, 0);
        } while ($decimal !== '0');

        return $sign . $result;
    }

    /**
     * Converts the given float to a plain decimal string without exponent.
     *
     * @param float|string $value The value to convert.
     */
    public static function convertExponentialToString(float|string $value): string
    {
        if (!is_float($value)) {
            return $value;
        }

        $string = strtoupper((string)$value);
        if (strpos($string, 'E') === false) {
            return $string;
        }

        [$mantissa, $exponent] = explode('E', $string);
        $negative = $mantissa[0] === '-';
        $mantissa = ltrim($mantissa, '-');
        [$int, $frac] = [...explode('.', $mantissa), ''];
        $shift = (int)$exponent;
        $digits = $int . $frac;
        $point = strlen($int) + $shift;

        if ($point <= 0) {
            $plain = '0.' . str_repeat('0', abs($point)) . $digits;
        } else {
            // PHP only uses an exponent when it is at least the precision, so the point is never inside the digits.
            $plain = $digits . str_repeat('0', $point - strlen($digits));
        }

        if (str_contains($plain, '.')) {
            $plain = rtrim($plain, '0');
            $plain = rtrim($plain, '.');
        }

        return ($negative ? '-' : '') . $plain;
    }

    private static function assertBase(int $base): void
    {
        if ($base < 2 || $base > 36) {
            throw new InvalidBaseException(sprintf(
                'Base %d is unsupported, should be between 2 and 36.',
                $base,
            ));
        }
    }

    private static function integerPart(string $number): string
    {
        $number = ltrim($number, '+');
        $dot = strpos($number, '.');

        return $dot === false ? $number : substr($number, 0, $dot);
    }
}
