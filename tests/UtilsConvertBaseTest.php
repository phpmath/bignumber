<?php
/**
 * This file is part of phpmath/bignumber. (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 * @copyright Copyright (c) 2015-2016 phpmath. (https://github.com/phpmath/)
 * @license https://raw.githubusercontent.com/phpmath/bignumber/master/LICENSE.md MIT
 */

namespace PHP\Math\BigNumberTest;

use PHP\Math\BigNumber\BigNumber;
use PHP\Math\BigNumber\Utils;
use PHPUnit_Framework_TestCase;

class UtilsConvertBaseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException RuntimeException
     */
    public function testConverBaseWithInvalidNumber()
    {
        // Arrange
        $number = new BigNumber('2');

        // Act
        Utils::convertBase($number, 2, 10);

        // Assert
        // ...
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConverBaseWithInvalidBase1()
    {
        // Arrange
        $number = new BigNumber('2');

        // Act
        Utils::convertBase($number, 1, 10);

        // Assert
        // ...
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConverBaseWithInvalidBase33()
    {
        // Arrange
        $number = new BigNumber('2');

        // Act
        Utils::convertBase($number, 10, 33);

        // Assert
        // ...
    }

    public function testConverBaseFrom10To10()
    {
        // Arrange
        $number = new BigNumber('2');

        // Act
        $converted = Utils::convertBase($number, 10, 10);

        // Assert
        $this->assertInternalType('string', $converted);
        $this->assertEquals('2.0000000000', $converted);
    }

    public function testConverBaseTo10()
    {
        // Arrange
        $number = new BigNumber('1010');

        // Act
        $converted = Utils::convertBase($number, 2, 10);

        // Assert
        $this->assertInternalType('string', $converted);
        $this->assertEquals('10.0000000000', $converted);
    }

    public function testConverBaseTo16()
    {
        // Arrange
        $number = new BigNumber('12345');

        // Act
        $converted = Utils::convertBase($number, 10, 16);

        // Assert
        $this->assertInternalType('string', $converted);
        $this->assertEquals('3039.0000000000', $converted);
    }
}
