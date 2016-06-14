<?php
/**
 * This file is part of phpmath/bignumber. (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 * @copyright Copyright (c) 2015-2016 phpmath. (https://github.com/phpmath/)
 * @license https://raw.githubusercontent.com/phpmath/bignumber/master/LICENSE.md MIT
 */

namespace PHP\Math\BigNumberTest;

use PHP\Math\BigNumber\Utils;
use PHPUnit_Framework_TestCase;

class UtilsConvertExponentialToStringTest extends PHPUnit_Framework_TestCase
{
    public function testFloat()
    {
        // Arrange
        $value = 0.0000000000000009;

        // Act
        $result = Utils::convertExponentialToString($value);

        // Assert
        $this->assertEquals('0.0000000000000009', $result);
    }

    public function testInteger()
    {
        // Arrange
        $value = '1337';

        // Act
        $result = Utils::convertExponentialToString($value);

        // Assert
        $this->assertEquals('1337', $result);
    }

    public function testString()
    {
        // Arrange
        $value = '0.0000000000000009';

        // Act
        $result = Utils::convertExponentialToString($value);

        // Assert
        $this->assertEquals('0.0000000000000009', $result);
    }
}
