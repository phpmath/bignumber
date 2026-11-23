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
#[CoversMethod(BigNumber::class, 'getValue')]
final class GetValueTest extends TestCase
{
    public function testReturnsValueWithScale(): void
    {
        // Arrange
        $number = new BigNumber('42.5', 2);

        // Act
        $result = $number->getValue();

        // Assert
        self::assertSame('42.50', $result);
    }
}
