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
#[CoversMethod(BigNumber::class, 'round')]
final class RoundTest extends TestCase
{
    public function testRoundsAHalfUpAwayFromZero(): void
    {
        // Arrange
        $number = new BigNumber('2.345', 3);

        // Act
        $result = $number->round(2);

        // Assert
        self::assertSame('2.35', $result->getValue());
        self::assertSame(2, $result->getScale());
    }

    public function testRoundsANegativeHalfDownAwayFromZero(): void
    {
        // Arrange
        $number = new BigNumber('-2.345', 3);

        // Act
        $result = $number->round(2);

        // Assert
        self::assertSame('-2.35', $result->getValue());
        self::assertSame(2, $result->getScale());
    }

    public function testRoundsBelowAHalfDown(): void
    {
        // Arrange
        $number = new BigNumber('2.344', 3);

        // Act
        $result = $number->round(2);

        // Assert
        self::assertSame('2.34', $result->getValue());
        self::assertSame(2, $result->getScale());
    }

    public function testRoundsAboveAHalfUp(): void
    {
        // Arrange
        $number = new BigNumber('2.346', 3);

        // Act
        $result = $number->round(2);

        // Assert
        self::assertSame('2.35', $result->getValue());
        self::assertSame(2, $result->getScale());
    }

    public function testRoundsANegativeNumberBelowAHalfTowardZero(): void
    {
        // Arrange
        $number = new BigNumber('-2.344', 3);

        // Act
        $result = $number->round(2);

        // Assert
        self::assertSame('-2.34', $result->getValue());
        self::assertSame(2, $result->getScale());
    }

    public function testRoundsToAWholeNumber(): void
    {
        // Arrange
        $number = new BigNumber('2.5', 1);

        // Act
        $result = $number->round(0);

        // Assert
        self::assertSame('3', $result->getValue());
        self::assertSame(0, $result->getScale());
    }

    public function testRoundsANegativeHalfToAWholeNumber(): void
    {
        // Arrange
        $number = new BigNumber('-2.5', 1);

        // Act
        $result = $number->round(0);

        // Assert
        self::assertSame('-3', $result->getValue());
        self::assertSame(0, $result->getScale());
    }

    public function testCarriesIntoTheWholePart(): void
    {
        // Arrange
        $number = new BigNumber('9.995', 3);

        // Act
        $result = $number->round(2);

        // Assert
        self::assertSame('10.00', $result->getValue());
        self::assertSame(2, $result->getScale());
    }

    public function testRoundsADigitThatLooksLikeAHalfButIsNot(): void
    {
        // Arrange
        $number = new BigNumber('1.4999', 4);

        // Act
        $result = $number->round(0);

        // Assert
        self::assertSame('1', $result->getValue());
        self::assertSame(0, $result->getScale());
    }

    public function testKeepsThePrecisionOfLargeNumbers(): void
    {
        // Arrange
        $number = new BigNumber('123456789012345678901234567890.555', 3);

        // Act
        $result = $number->round(2);

        // Assert
        self::assertSame('123456789012345678901234567890.56', $result->getValue());
        self::assertSame(2, $result->getScale());
    }

    public function testNegativeValueThatRoundsToZeroHasNoMinusSign(): void
    {
        // Arrange
        $number = new BigNumber('-0.004', 3);

        // Act
        $result = $number->round(2);

        // Assert
        self::assertSame('0.00', $result->getValue());
        self::assertSame(2, $result->getScale());
    }

    public function testScaleEqualToTheCurrentScaleChangesNothing(): void
    {
        // Arrange
        $number = new BigNumber('2.345', 3);

        // Act
        $result = $number->round(3);

        // Assert
        self::assertSame('2.345', $result->getValue());
        self::assertSame(3, $result->getScale());
    }

    public function testLargerScaleAddsZeros(): void
    {
        // Arrange
        $number = new BigNumber('2.5', 1);

        // Act
        $result = $number->round(3);

        // Assert
        self::assertSame('2.500', $result->getValue());
        self::assertSame(3, $result->getScale());
    }

    public function testReturnsNewInstanceAndKeepsOriginal(): void
    {
        // Arrange
        $number = new BigNumber('2.345', 3);

        // Act
        $result = $number->round(1);

        // Assert
        self::assertNotSame($number, $result);
        self::assertSame('2.345', $number->getValue());
        self::assertSame(3, $number->getScale());
    }

    public function testWithScaleCutsWhereRoundRounds(): void
    {
        // Arrange
        $number = new BigNumber('2.999', 3);

        // Act
        $result = [$number->withScale(2)->getValue(), $number->round(2)->getValue()];

        // Assert
        self::assertSame(['2.99', '3.00'], $result);
    }

    public function testNegativeScaleThrowsException(): void
    {
        // Arrange
        $number = new BigNumber('1.5', 2);

        // Assert
        $this->expectException(InvalidScaleException::class);
        $this->expectExceptionMessage('Invalid scale "-1" provided. Should be 0 or higher.');

        // Act
        $number->round(-1);
    }
}
