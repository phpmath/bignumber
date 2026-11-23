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

use function str_repeat;

#[CoversClass(BigNumber::class)]
#[CoversMethod(BigNumber::class, 'divide')]
final class DivideTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testReturnsExpectedValue(string $start, string|int|float $operand, string $expected): void
    {
        // Arrange
        $number = new BigNumber($start);

        // Act
        $result = $number->divide($operand);

        // Assert
        self::assertSame($expected, $result->getValue());
    }

    public function testAcceptsBigNumberOperand(): void
    {
        // Arrange
        $number = new BigNumber('10');
        $operand = new BigNumber('4');

        // Act
        $result = $number->divide($operand);

        // Assert
        self::assertSame($number->divide(4)->getValue(), $result->getValue());
    }

    public function testReturnsNewInstanceAndKeepsOriginal(): void
    {
        // Arrange
        $number = new BigNumber('10');

        // Act
        $result = $number->divide(2);

        // Assert
        self::assertNotSame($number, $result);
        self::assertSame('10.0000000000', $number->getValue());
    }

    public function testKeepsScaleOfOriginal(): void
    {
        // Arrange
        $number = new BigNumber('10', 3);

        // Act
        $result = $number->divide(2);

        // Assert
        self::assertSame(3, $result->getScale());
    }

    public function testThrowsOnNonNumericOperand(): void
    {
        // Arrange
        $number = new BigNumber('10');

        // Act
        $this->expectException(InvalidValueException::class);
        $number->divide('abc');

        // Assert
        // Handled by expectException.
    }

    /** @return array<string, array{string, string|int|float, string}> */
    public static function provideCases(): array
    {
        return [
            'integer' => ['10', 4, '2.5000000000'],
            'float' => ['1234567890.1234567890', 12.34, '100046020.2693238888'],
            'same' => ['1234567890.1234567890', '1234567890.1234567890', '1.0000000000'],
            'small divisor' => ['1', '0.00000000001', '100000000000.0000000000'],
            'negative' => ['-9', 3, '-3.0000000000'],
            'tiny divisor' => ['1', '1e-28', '10000000000000000000000000000.0000000000'],
            'tiny divisor plain' => ['1', '0.0000000000000000000000000001', '10000000000000000000000000000.0000000000'],
            'tiny float divisor' => ['1', 1.0E-20, '100000000000000000000.0000000000'],
            'huge divisor' => ['1', '1e30', '0.0000000000'],
            'long divisor' => ['1', '3.0000000000000000000000000001', '0.3333333333'],
        ];
    }

    public function testDividesByTinyDivisorInsteadOfTreatingItAsZero(): void
    {
        // Arrange
        $number = new BigNumber('1', 40);

        // Act
        $result = $number->divide('1e-38');

        // Assert
        self::assertSame('100000000000000000000000000000000000000.' . str_repeat('0', 40), $result->getValue());
    }

    public function testThrowsOnZeroDivisorWrittenWithManyDecimals(): void
    {
        // Arrange
        $number = new BigNumber('10');

        // Act
        $this->expectException(DivisionByZeroException::class);
        $number->divide('0.000000000000000000000000000000');

        // Assert
        // Handled by expectException.
    }

    public function testThrowsOnZeroDivisor(): void
    {
        // Arrange
        $number = new BigNumber('10');

        // Act
        $this->expectException(DivisionByZeroException::class);
        $number->divide('0');

        // Assert
        // Handled by expectException.
    }
}
