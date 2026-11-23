<?php
/**
 * phpmath / bignumber (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\BigNumber\Tests\BigNumber;

use PHPMath\BigNumber\BigNumber;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(BigNumber::class)]
#[CoversMethod(BigNumber::class, 'getScale')]
final class GetScaleTest extends TestCase
{
    public function testReturnsScale(): void
    {
        // Arrange
        $number = new BigNumber('1', 7);

        // Act
        $result = $number->getScale();

        // Assert
        self::assertSame(7, $result);
    }
}
