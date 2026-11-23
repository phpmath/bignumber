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
use PHPMath\BigNumber\Exception\InvalidValueException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BigNumber::class)]
#[CoversMethod(BigNumber::class, '__construct')]
final class ConstructTest extends TestCase
{
    #[DataProvider('provideValidValues')]
    public function testNormalizesValue(string|int|float|BigNumber $value, string $expected): void
    {
        // Arrange
        // Nothing to arrange, the value comes from the provider.

        // Act
        $number = new BigNumber($value);

        // Assert
        self::assertSame($expected, $number->getValue());
    }

    #[DataProvider('provideInvalidValues')]
    public function testThrowsOnInvalidValue(string $value): void
    {
        // Arrange
        // Nothing to arrange, the value comes from the provider.

        // Act
        $this->expectException(InvalidValueException::class);
        new BigNumber($value);

        // Assert
        // Handled by expectException.
    }

    public function testDefaultsToZeroWithScaleTen(): void
    {
        // Arrange
        // Nothing to arrange.

        // Act
        $number = new BigNumber();

        // Assert
        self::assertSame('0.0000000000', $number->getValue());
        self::assertSame(10, $number->getScale());
    }

    public function testTruncatesToCustomScale(): void
    {
        // Arrange
        // Nothing to arrange.

        // Act
        $number = new BigNumber('12345.67890', 2);

        // Assert
        self::assertSame('12345.67', $number->getValue());
        self::assertSame(2, $number->getScale());
    }

    public function testThrowsOnNegativeScale(): void
    {
        // Arrange
        // Nothing to arrange.

        // Act
        $this->expectException(InvalidScaleException::class);
        new BigNumber('1', -1);

        // Assert
        // Handled by expectException.
    }

    /** @return array<string, array{string|int|float|BigNumber, string}> */
    public static function provideValidValues(): array
    {
        return [
            'integer' => [1234567890, '1234567890.0000000000'],
            'negative integer' => [-5, '-5.0000000000'],
            'float' => [1234567890.125, '1234567890.1250000000'],
            'tiny float' => [0.0000000000000009, '0.0000000000'],
            'exponential float' => [1.5E-7, '0.0000001500'],
            'large exponential float' => [1.0E+25, '10000000000000000000000000.0000000000'],
            'string integer' => ['1234567890', '1234567890.0000000000'],
            'string decimal' => ['1234567890.123123123', '1234567890.1231231230'],
            'leading dot' => ['.5', '0.5000000000'],
            'plus sign' => ['+5', '5.0000000000'],
            'exponent string' => ['1.5e3', '1500.0000000000'],
            'negative exponent string' => ['25e-2', '0.2500000000'],
            'big number' => [new BigNumber('12345'), '12345.0000000000'],
        ];
    }

    /** @return array<string, array{string}> */
    public static function provideInvalidValues(): array
    {
        return [
            'text' => ['abc'],
            'empty' => [''],
            'only sign' => ['-'],
            'only dot' => ['.'],
            'surrounding whitespace' => [' 1 '],
            'two dots' => ['1.2.3'],
            'hex' => ['0x1A'],
        ];
    }
}
