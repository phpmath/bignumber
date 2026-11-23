<?php
/**
 * phpmath / bignumber (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\BigNumber\Tests\Utils;

use PHPMath\BigNumber\Utils;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Utils::class)]
#[CoversMethod(Utils::class, 'convertExponentialToString')]
final class ConvertExponentialToStringTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testConvertsToPlainString(float|string $value, string $expected): void
    {
        // Arrange
        // Nothing to arrange, the value comes from the provider.

        // Act
        $result = Utils::convertExponentialToString($value);

        // Assert
        self::assertSame($expected, $result);
    }

    /** @return array<string, array{float|string, string}> */
    public static function provideCases(): array
    {
        return [
            'tiny float' => [0.0000000000000009, '0.0000000000000009'],
            'tiny float with decimals' => [1.5E-10, '0.00000000015'],
            'negative tiny float' => [-2.5E-10, '-0.00000000025'],
            'huge float' => [1.0E+25, '10000000000000000000000000'],
            'huge float with decimals' => [1.2345E+25, '12345000000000000000000000'],
            'plain float' => [1.5, '1.5'],
            'string is untouched' => ['1337', '1337'],
        ];
    }
}
