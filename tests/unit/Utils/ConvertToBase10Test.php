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
#[CoversMethod(Utils::class, 'convertToBase10')]
final class ConvertToBase10Test extends TestCase
{
    #[DataProvider('provideCases')]
    public function testConvertsToBase10(string|int|float|BigNumber $number, int $fromBase, string $expected): void
    {
        // Arrange
        // Nothing to arrange, the value comes from the provider.

        // Act
        $result = Utils::convertToBase10($number, $fromBase);

        // Assert
        self::assertSame($expected, $result);
    }

    /** @param class-string<Throwable> $exception */
    #[DataProvider('provideInvalidCases')]
    public function testThrowsOnInvalidInput(string $number, int $fromBase, string $exception): void
    {
        // Arrange
        // Nothing to arrange, the value comes from the provider.

        // Act
        $this->expectException($exception);
        Utils::convertToBase10($number, $fromBase);

        // Assert
        // Handled by expectException.
    }

    /** @return array<string, array{string|int|float|BigNumber, int, string}> */
    public static function provideCases(): array
    {
        return [
            'binary' => ['1010', 2, '10'],
            'hex upper' => ['FF', 16, '255'],
            'hex lower' => ['ff', 16, '255'],
            'base 36' => ['ZZ', 36, '1295'],
            'base 10' => [12345, 10, '12345'],
            'negative' => ['-101', 2, '-5'],
            'zero' => ['0', 2, '0'],
            'huge' => ['FFFFFFFFFFFFFFFFFFFF', 16, '1208925819614629174706175'],
            'fraction discarded' => ['101.11', 2, '5'],
            'big number' => [new BigNumber('1010'), 2, '10'],
        ];
    }

    /** @return array<string, array{string, int, class-string<Throwable>}> */
    public static function provideInvalidCases(): array
    {
        return [
            'digit too high' => ['2', 2, InvalidValueException::class],
            'unknown digit' => ['1_0', 10, InvalidValueException::class],
            'base too low' => ['1', 1, InvalidBaseException::class],
            'base too high' => ['1', 37, InvalidBaseException::class],
            'empty' => ['', 10, InvalidValueException::class],
        ];
    }
}
