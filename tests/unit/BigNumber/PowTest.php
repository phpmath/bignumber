<?php
/**
 * phpmath / bignumber (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\BigNumber\Tests\BigNumber;

use PHPMath\BigNumber\BigNumber;
use PHPMath\BigNumber\Exception\InvalidExponentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BigNumber::class)]
#[CoversMethod(BigNumber::class, 'pow')]
final class PowTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testReturnsExpectedValue(string $start, int|string $exponent, string $expected): void
    {
        // Arrange
        $number = new BigNumber($start);

        // Act
        $result = $number->pow($exponent);

        // Assert
        self::assertSame($expected, $result->getValue());
    }

    #[DataProvider('provideInvalidExponents')]
    public function testThrowsOnInvalidExponent(string $exponent): void
    {
        // Arrange
        $number = new BigNumber('2');

        // Act
        $this->expectException(InvalidExponentException::class);
        $number->pow($exponent);

        // Assert
        // Handled by expectException.
    }

    public function testNegativeStringGivesSameResultAsNegativeInt(): void
    {
        // Arrange
        $number = new BigNumber('3');

        // Act
        $result = $number->pow('-2');

        // Assert
        self::assertSame($number->pow(-2)->getValue(), $result->getValue());
    }

    public function testReturnsNewInstanceAndKeepsOriginal(): void
    {
        // Arrange
        $number = new BigNumber('2');

        // Act
        $result = $number->pow(3);

        // Assert
        self::assertNotSame($number, $result);
        self::assertSame('2.0000000000', $number->getValue());
    }

    /** @return array<string, array{string, int|string, string}> */
    public static function provideCases(): array
    {
        return [
            'int exponent' => ['2', 10, '1024.0000000000'],
            'string exponent' => ['2', '10', '1024.0000000000'],
            'zero exponent' => ['7', 0, '1.0000000000'],
            'fraction base' => ['1.5', 2, '2.2500000000'],
            'negative exponent' => ['2', -1, '0.5000000000'],
            'negative string exponent' => ['2', '-2', '0.2500000000'],
            'negative zero string exponent' => ['2', '-0', '1.0000000000'],
            'big result' => ['123456789', 3, '1881676371789154860897069.0000000000'],
        ];
    }

    /** @return array<string, array{string}> */
    public static function provideInvalidExponents(): array
    {
        return [
            'float string' => ['1.5'],
            'text' => ['abc'],
            'empty' => [''],
            'negative float string' => ['-1.5'],
            'double minus' => ['--2'],
            'only minus' => ['-'],
        ];
    }
}
