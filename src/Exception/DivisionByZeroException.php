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
 * Thrown when dividing by zero or taking a modulo of zero.
 */
final class DivisionByZeroException extends InvalidArgumentException implements BigNumberException
{
}
