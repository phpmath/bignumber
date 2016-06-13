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

class UtilsGetPlainNumberTest extends PHPUnit_Framework_TestCase
{
    public function testGetPlainNumberWithBigNumber()
    {
        // Arrange
        $number = new BigNumber(123);

        // Act
        $result = Utils::getPlainNumber($number);

        // Assert
        $this->assertInternalType('string', $result);
        $this->assertEquals('123', $result);
    }

    public function testGetPlainNumberWithFloat()
    {
        // Arrange
        $number = 123.0;

        // Act
        $result = Utils::getPlainNumber($number);

        // Assert
        $this->assertInternalType('string', $result);
        $this->assertEquals('123.0', $result);
    }

    public function testGetPlainNumberWithInteger()
    {
        // Arrange
        $number = 123;

        // Act
        $result = Utils::getPlainNumber($number);

        // Assert
        $this->assertInternalType('string', $result);
        $this->assertEquals('123', $result);
    }

    public function testGetPlainNumberWithString()
    {
        // Arrange
        $number = '123';

        // Act
        $result = Utils::getPlainNumber($number);

        // Assert
        $this->assertInternalType('string', $result);
        $this->assertEquals('123', $result);
    }
}
