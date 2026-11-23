<?php
/**
 * phpmath / bignumber (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\BigNumber\Tests\BigNumber;

use PHPMath\BigNumber\BigNumber;
use PHPMath\BigNumber\Exception\InvalidScaleException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(BigNumber::class)]
#[CoversMethod(BigNumber::class, 'withScale')]
final class WithScaleTest extends TestCase
{
    public function testChangesScale(): void
    {
        // Arrange
        $number = new BigNumber('12345.6789', 4);

        // Act
        $result = $number->withScale(2);

        // Assert
        self::assertSame(2, $result->getScale());
        self::assertSame('12345.67', $result->getValue());
    }

    public function testReturnsNewInstanceAndKeepsOriginal(): void
    {
        // Arrange
        $number = new BigNumber('1.5', 2);

        // Act
        $result = $number->withScale(5);

        // Assert
        self::assertNotSame($number, $result);
        self::assertSame(2, $number->getScale());
        self::assertSame('1.50', $number->getValue());
        self::assertSame('1.50000', $result->getValue());
    }

    public function testThrowsOnNegativeScale(): void
    {
        // Arrange
        $number = new BigNumber('1');

        // Act
        $this->expectException(InvalidScaleException::class);
        $number->withScale(-1);

        // Assert
        // Handled by expectException.
    }
}
