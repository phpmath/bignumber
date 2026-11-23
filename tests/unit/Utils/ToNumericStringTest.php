<?php
/**
 * phpmath / bignumber (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\BigNumber\Tests\Utils;

use PHPMath\BigNumber\BigNumber;
use PHPMath\BigNumber\Exception\InvalidValueException;
use PHPMath\BigNumber\Utils;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Utils::class)]
#[CoversMethod(Utils::class, 'toNumericString')]
final class ToNumericStringTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testConvertsToPlainDecimal(string|int|float $value, string $expected): void
    {
        // Arrange
        // Nothing to arrange, the value comes from the provider.

        // Act
        $result = Utils::toNumericString($value);

        // Assert
        self::assertSame($expected, $result);
    }

    public function testThrowsOnNonNumeric(): void
    {
        // Arrange
        // Nothing to arrange.

        // Act
        $this->expectException(InvalidValueException::class);
        Utils::toNumericString('1e');

        // Assert
        // Handled by expectException.
    }

    /** @return array<string, array{string|int|float, string}> */
    public static function provideCases(): array
    {
        return [
            'integer' => [42, '42'],
            'strips leading zeros' => ['007', '7'],
            'strips trailing zeros' => ['1.500', '1.5'],
            'exponent up' => ['12.5e2', '1250'],
            'exponent down' => ['12.5e-2', '0.125'],
            'negative' => ['-0.5', '-0.5'],
            'float' => [0.25, '0.25'],
        ];
    }

    public function testReturnsTheValueOfABigNumber(): void
    {
        // Arrange
        $number = new BigNumber('1.5', 2);

        // Act
        $result = Utils::toNumericString($number);

        // Assert
        self::assertSame('1.50', $result);
    }

    public function testMovesTheDecimalPointInsideTheDigits(): void
    {
        // Arrange
        $value = '12345E-2';

        // Act
        $result = Utils::toNumericString($value);

        // Assert
        self::assertSame('123.45', $result);
    }
}
