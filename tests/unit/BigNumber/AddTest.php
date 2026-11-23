<?php
/**
 * phpmath / bignumber (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\BigNumber\Tests\BigNumber;

use PHPMath\BigNumber\BigNumber;
use PHPMath\BigNumber\Exception\InvalidValueException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BigNumber::class)]
#[CoversMethod(BigNumber::class, 'add')]
final class AddTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testReturnsExpectedValue(string $start, string|int|float $operand, string $expected): void
    {
        // Arrange
        $number = new BigNumber($start);

        // Act
        $result = $number->add($operand);

        // Assert
        self::assertSame($expected, $result->getValue());
    }

    public function testAcceptsBigNumberOperand(): void
    {
        // Arrange
        $number = new BigNumber('10');
        $operand = new BigNumber('4');

        // Act
        $result = $number->add($operand);

        // Assert
        self::assertSame($number->add(4)->getValue(), $result->getValue());
    }

    public function testReturnsNewInstanceAndKeepsOriginal(): void
    {
        // Arrange
        $number = new BigNumber('10');

        // Act
        $result = $number->add(2);

        // Assert
        self::assertNotSame($number, $result);
        self::assertSame('10.0000000000', $number->getValue());
    }

    public function testKeepsScaleOfOriginal(): void
    {
        // Arrange
        $number = new BigNumber('10', 3);

        // Act
        $result = $number->add(2);

        // Assert
        self::assertSame(3, $result->getScale());
    }

    public function testThrowsOnNonNumericOperand(): void
    {
        // Arrange
        $number = new BigNumber('10');

        // Act
        $this->expectException(InvalidValueException::class);
        $number->add('abc');

        // Assert
        // Handled by expectException.
    }

    /** @return array<string, array{string, string|int|float, string}> */
    public static function provideCases(): array
    {
        return [
            'integer' => ['10', 5, '15.0000000000'],
            'float' => ['1.5', 2.25, '3.7500000000'],
            'string' => ['1234567890.1234567890', '0.0000000010', '1234567890.1234567900'],
            'negative' => ['1', '-3', '-2.0000000000'],
            'exponent string' => ['1', '1e2', '101.0000000000'],
        ];
    }
}
