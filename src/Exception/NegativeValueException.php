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
 * Thrown when an operation does not accept a negative number.
 */
final class NegativeValueException extends InvalidArgumentException implements BigNumberException
{
}
