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
 * Thrown when an exponent is not an integer.
 */
final class InvalidExponentException extends InvalidArgumentException implements BigNumberException
{
}
