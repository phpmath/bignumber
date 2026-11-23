<?php
/**
 * phpmath / bignumber (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\BigNumber\Tests\Utils;

use PHPMath\BigNumber\BigNumber;
use PHPMath\BigNumber\Exception\InvalidBaseException;
use PHPMath\BigNumber\Exception\InvalidValueException;
use PHPMath\BigNumber\Utils;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Throwable;

#[CoversClass(Utils::class)]
#[CoversMethod(Utils::class, 'convertBase')]
final class ConvertBaseTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testConvertsBetweenBases(
        string|int|float|BigNumber $number,
        int $fromBase,
        int $toBase,
        string $expected,
    ): void {
        // Arrange
        // Nothing to arrange, the value comes from the provider.

        // Act
        $result = Utils::convertBase($number, $fromBase, $toBase);

        // Assert
        self::assertSame($expected, $result);
    }

    /** @param class-string<Throwable> $exception */
    #[DataProvider('provideInvalidCases')]
    public function testThrowsOnInvalidInput(string $number, int $fromBase, int $toBase, string $exception): void
    {
        // Arrange
        // Nothing to arrange, the value comes from the provider.

        // Act
        $this->expectException($exception);
        Utils::convertBase($number, $fromBase, $toBase);

        // Assert
        // Handled by expectException.
    }

    /** @return array<string, array{string|int|float|BigNumber, int, int, string}> */
    public static function provideCases(): array
    {
        return [
            'same base' => ['2', 10, 10, '2'],
            'binary to decimal' => ['1010', 2, 10, '10'],
            'decimal to hex' => ['12345', 10, 16, '3039'],
            'zero' => ['0', 10, 2, '0'],
            'negative to decimal' => ['-101', 2, 10, '-5'],
            'negative to hex' => ['-255', 10, 16, '-FF'],
            'huge' => ['1208925819614629174706175', 10, 16, 'FFFFFFFFFFFFFFFFFFFF'],
            'big number' => [new BigNumber('12345'), 10, 16, '3039'],
        ];
    }

    /** @return array<string, array{string, int, int, class-string<Throwable>}> */
    public static function provideInvalidCases(): array
    {
        return [
            'invalid digit' => ['2', 2, 10, InvalidValueException::class],
            'from base too low' => ['2', 1, 10, InvalidBaseException::class],
            'to base too high' => ['2', 10, 37, InvalidBaseException::class],
        ];
    }
}
