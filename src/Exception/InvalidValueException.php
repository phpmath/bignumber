<?php
/**
 * phpmath / bignumber (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\BigNumber\Exception;

use InvalidArgumentException;

/**
 * Thrown when a value is not a valid number, or a digit is not valid for the base.
 */
final class InvalidValueException extends InvalidArgumentException implements BigNumberException
{
}
