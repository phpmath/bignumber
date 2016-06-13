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

class UtilsConvertToBase10Test extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException RuntimeException
     */
    public function testConverToBase10WithInvalidNumber()
    {
        // Arrange
        $number = new BigNumber('2');

        // Act
        Utils::convertToBase10($number, 2);

        // Assert
        // ...
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConverToBase10WithInvalidBase1()
    {
        // Arrange
        $number = new BigNumber('2');

        // Act
        Utils::convertToBase10($number, 1);

        // Assert
        // ...
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConverToBase10WithInvalidBase33()
    {
        // Arrange
        $number = new BigNumber('2');

        // Act
        Utils::convertToBase10($number, 33);

        // Assert
        // ...
    }

    public function testConverToBase10WithBase10()
    {
        // Arrange
        $number = new BigNumber('2');

        // Act
        $converted = Utils::convertToBase10($number, 10);

        // Assert
        $this->assertInternalType('string', $converted);
        $this->assertEquals('2.0000000000', $converted);
    }

    public function testConverToBase10FromBinary()
    {
        // Arrange
        $number = new BigNumber('1010');

        // Act
        $converted = Utils::convertToBase10($number, 2);

        // Assert
        $this->assertInternalType('string', $converted);
        $this->assertEquals('10.0000000000', $converted);
    }

    public function testConverToBase10FromHex()
    {
        // Arrange
        $number = new BigNumber('12345');

        // Act
        $converted = Utils::convertToBase10($number, 16);

        // Assert
        $this->assertInternalType('string', $converted);
        $this->assertEquals('74565.0000000000', $converted);
    }

    public function testConverToBase10FromOctal()
    {
        // Arrange
        $number = new BigNumber('12345');

        // Act
        $converted = Utils::convertToBase10($number, 8);

        // Assert
        $this->assertInternalType('string', $converted);
        $this->assertEquals('5349.0000000000', $converted);
    }
}
