<?php
/**
 * phpmath / bignumber (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\BigNumber\Tests\BigNumber;

use PHPMath\BigNumber\BigNumber;
use PHPMath\BigNumber\Exception\NegativeValueException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BigNumber::class)]
#[CoversMethod(BigNumber::class, 'sqrt')]
final class SqrtTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testReturnsExpectedValue(string $start, string $expected): void
    {
        // Arrange
        $number = new BigNumber($start);

        // Act
        $result = $number->sqrt();

        // Assert
        self::assertSame($expected, $result->getValue());
    }

    public function testThrowsOnNegativeNumber(): void
    {
        // Arrange
        $number = new BigNumber('-4');

        // Act
        $this->expectException(NegativeValueException::class);
        $number->sqrt();

        // Assert
        // Handled by expectException.
    }

    public function testReturnsNewInstanceAndKeepsOriginal(): void
    {
        // Arrange
        $number = new BigNumber('16');

        // Act
        $result = $number->sqrt();

        // Assert
        self::assertNotSame($number, $result);
        self::assertSame('16.0000000000', $number->getValue());
    }

    /** @return array<string, array{string, string}> */
    public static function provideCases(): array
    {
        return [
            'perfect square' => ['16', '4.0000000000'],
            'irrational' => ['2', '1.4142135623'],
            'zero' => ['0', '0.0000000000'],
            'fraction' => ['0.25', '0.5000000000'],
        ];
    }
}
