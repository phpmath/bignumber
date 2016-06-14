<?php
/**
 * This file is part of phpmath/bignumber. (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 * @copyright Copyright (c) 2015-2016 phpmath. (https://github.com/phpmath/)
 * @license https://raw.githubusercontent.com/phpmath/bignumber/master/LICENSE.md MIT
 */

namespace PHP\Math\BigNumber;

use InvalidArgumentException;
use RuntimeException;

/**
 * A utility class.
 */
final class Utils
{
    const BASE32_ALPHABET = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Gets the plain number from the given input. Converts a BigNumber to a string.
     *
     * @param string|int|BigNumber $number The number to convert.
     * @return string
     */
    public static function getPlainNumber($number)
    {
        if ($number instanceof BigNumber) {
            $number = $number->getValue();
        }

        return (string)$number;
    }

    /**
     * Converts the provided number from an arbitrary base to to a base 10 number.
     *
     * @param string|int|BigNumber $number The number to convert.
     * @param int $fromBase The base to convert the number from.
     * @return string
     * @throws InvalidArgumentException Thrown when the base is out of reach.
     */
    public static function convertToBase10($number, $fromBase)
    {
        $number = (string)ceil(static::getPlainNumber($number));

        if ($fromBase == 10) {
            return $number;
        } elseif ($fromBase < 2 || $fromBase > 32) {
            throw new InvalidArgumentException(sprintf(
                'Base %d is unsupported, should be between 2 and 32.',
                $fromBase
            ));
        }

        $result = '0';
        $chars = self::BASE32_ALPHABET;

        for ($i = 0, $len = strlen($number); $i < $len; $i++) {
            $index = strpos($chars, $number[$i]);

            if ($index >= $fromBase) {
                throw new RuntimeException(sprintf(
                    'The digit %s in the number %s is an invalid digit for base-%s.',
                    $chars[$index],
                    $number,
                    $fromBase
                ));
            }

            $result = bcmul($result, $fromBase);
            $result = bcadd($result, strpos($chars, $number[$i]));
        }

        return $result;
    }

    /**
     * Converts the provided number from an arbitrary base to another arbitrary base (from 2 to 36).
     *
     * @param string|int|BigNumber $number The number to convert.
     * @param int $fromBase The base to convert the number from.
     * @param int $toBase The base to convert the number to.
     * @return string
     * @throws InvalidArgumentException Thrown when the base is out of reach.
     */
    public static function convertBase($number, $fromBase, $toBase)
    {
        $number = static::getPlainNumber($number);

        if ($fromBase == $toBase) {
            return $number;
        }

        if ($fromBase < 2 || $fromBase > 32) {
            throw new InvalidArgumentException(sprintf(
                'Base %d is unsupported, should be between 2 and 32.',
                $fromBase
            ));
        }

        if ($toBase < 2 || $toBase > 32) {
            throw new InvalidArgumentException(sprintf(
                'Base %d is unsupported, should be between 2 and 32.',
                $toBase
            ));
        }

        // Save the sign and trim it off so we can easier calculate the number:
        $sign = (strpos($number, '-') === 0) ? '-' : '';
        $number = ltrim($number, '-+');

        // First we convert the number to a decimal value:
        $decimal = static::convertToBase10($number, $fromBase);
        if ($toBase == 10) {
            return $decimal;
        }

        // Next we convert to the correct base:
        $result = '';
        $chars = self::BASE32_ALPHABET;

        do {
            $remainder = bcmod($decimal, $toBase);
            $decimal = bcdiv($decimal, $toBase);
            $result = $chars[$remainder] . $result;
        } while (bccomp($decimal, '0'));

        return $sign . ltrim($result, '0');
    }

    /**
     * Converts the given exponential value to a string.
     *
     * @param float|string $value The exponential value to convert.
     * @return string
     */
    public static function convertExponentialToString($value)
    {
        if (!is_float($value)) {
            return $value;
        }

        $result = explode('E', strtoupper($value));

        if (count($result) === 1) {
            return $result[0];
        }

        $dotSplitted = explode('.', $result[0]);

        return '0.' . str_repeat('0', abs($result[1]) - 1) . $dotSplitted[0];
    }

    /**
     * Multiplies the two given numbers.
     *
     * @param BigNumber $lft The left number.
     * @param BigNumber $rgt The right number.
     * @param int $scale The scale of the calculated number.
     * @param bool $mutable Whether or not the result is mutable.
     * @return BigNumber
     */
    public static function multiply(BigNumber $lft, BigNumber $rgt, $scale = 10, $mutable = true)
    {
        $bigNumber = new BigNumber($lft, $scale, $mutable);

        return $bigNumber->multiply($rgt);
    }
}
