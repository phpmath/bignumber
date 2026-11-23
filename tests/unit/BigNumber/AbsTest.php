<?php
/**
 * phpmath / bignumber (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\BigNumber\Tests\BigNumber;

use PHPMath\BigNumber\BigNumber;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BigNumber::class)]
#[CoversMethod(BigNumber::class, 'abs')]
final class AbsTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testReturnsExpectedValue(string $start, string $expected): void
    {
        // Arrange
        $number = new BigNumber($start);

        // Act
        $result = $number->abs();

        // Assert
        self::assertSame($expected, $result->getValue());
    }

    public function testReturnsNewInstanceAndKeepsOriginal(): void
    {
        // Arrange
        $number = new BigNumber('-5');

        // Act
        $result = $number->abs();

        // Assert
        self::assertNotSame($number, $result);
        self::assertSame('-5.0000000000', $number->getValue());
    }

    /** @return array<string, array{string, string}> */
    public static function provideCases(): array
    {
        return [
            'negative' => ['-1234567890.1234567890', '1234567890.1234567890'],
            'positive' => ['12.5', '12.5000000000'],
            'zero' => ['0', '0.0000000000'],
        ];
    }
}
