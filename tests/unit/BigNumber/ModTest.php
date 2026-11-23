<?php
/**
 * phpmath / bignumber (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\BigNumber\Tests\BigNumber;

use PHPMath\BigNumber\BigNumber;
use PHPMath\BigNumber\Exception\DivisionByZeroException;
use PHPMath\BigNumber\Exception\InvalidValueException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BigNumber::class)]
#[CoversMethod(BigNumber::class, 'mod')]
final class ModTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testReturnsExpectedValue(string $start, string|int|float $operand, string $expected): void
    {
        // Arrange
        $number = new BigNumber($start);

        // Act
        $result = $number->mod($operand);

        // Assert
        self::assertSame($expected, $result->getValue());
    }

    public function testAcceptsBigNumberOperand(): void
    {
        // Arrange
        $number = new BigNumber('10');
        $operand = new BigNumber('4');

        // Act
        $result = $number->mod($operand);

        // Assert
        self::assertSame($number->mod(4)->getValue(), $result->getValue());
    }

    public function testReturnsNewInstanceAndKeepsOriginal(): void
    {
        // Arrange
        $number = new BigNumber('10');

        // Act
        $result = $number->mod(2);

        // Assert
        self::assertNotSame($number, $result);
        self::assertSame('10.0000000000', $number->getValue());
    }

    public function testKeepsScaleOfOriginal(): void
    {
        // Arrange
        $number = new BigNumber('10', 3);

        // Act
        $result = $number->mod(2);

        // Assert
        self::assertSame(3, $result->getScale());
    }

    public function testThrowsOnNonNumericOperand(): void
    {
        // Arrange
        $number = new BigNumber('10');

        // Act
        $this->expectException(InvalidValueException::class);
        $number->mod('abc');

        // Assert
        // Handled by expectException.
    }

    /** @return array<string, array{string, string|int|float, string}> */
    public static function provideCases(): array
    {
        return [
            'integers' => ['10', 3, '1.0000000000'],
            'fraction kept' => ['10.5', 3, '1.5000000000'],
            'negative dividend' => ['-10', 3, '-1.0000000000'],
            'fraction divisor' => ['5', '1.5', '0.5000000000'],
            'tiny divisor' => ['1', '1e-28', '0.0000000000'],
            'huge divisor' => ['7', '1e30', '7.0000000000'],
        ];
    }

    public function testUsesTinyDivisorInsteadOfTreatingItAsZero(): void
    {
        // Arrange
        $number = new BigNumber('1', 30);

        // Act
        $result = $number->mod('3e-28');

        // Assert
        self::assertSame('0.000000000000000000000000000100', $result->getValue());
    }

    public function testThrowsOnZeroDivisorWrittenWithManyDecimals(): void
    {
        // Arrange
        $number = new BigNumber('10');

        // Act
        $this->expectException(DivisionByZeroException::class);
        $number->mod('0.000000000000000000000000000000');

        // Assert
        // Handled by expectException.
    }

    public function testThrowsOnZeroDivisor(): void
    {
        // Arrange
        $number = new BigNumber('10');

        // Act
        $this->expectException(DivisionByZeroException::class);
        $number->mod('0');

        // Assert
        // Handled by expectException.
    }
}
