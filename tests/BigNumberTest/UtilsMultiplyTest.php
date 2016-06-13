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

class UtilsMultiplyTest extends PHPUnit_Framework_TestCase
{
    public function testMultiply()
    {
        // Arrange
        $number1 = new BigNumber('0.123456789');
        $number2 = new BigNumber(2);

        // Act
        $result = Utils::multiply($number1, $number2);

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $result);
        $this->assertEquals('0.2469135780', (string)$result);
        $this->assertEquals('0.123456789', $number1);
        $this->assertEquals('2.0000000000', $number2);
        $this->assertTrue($result->isMutable());
    }

    public function testMultiplyWithScale()
    {
        // Arrange
        $number1 = new BigNumber('0.123456789');
        $number2 = new BigNumber(2);

        // Act
        $result = Utils::multiply($number1, $number2, 5);

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $result);
        $this->assertEquals('0.24690', (string)$result);
        $this->assertEquals('0.123456789', $number1);
        $this->assertEquals('2.0000000000', $number2);
        $this->assertTrue($result->isMutable());
    }

    public function testMultiplyWithMutableFalse()
    {
        // Arrange
        $number1 = new BigNumber('0.123456789');
        $number2 = new BigNumber(2);

        // Act
        $result = Utils::multiply($number1, $number2, 10, false);

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $result);
        $this->assertEquals('0.2469135780', (string)$result);
        $this->assertEquals('0.123456789', $number1);
        $this->assertEquals('2.0000000000', $number2);
        $this->assertFalse($result->isMutable());
    }

    public function testMultiplyWithMutableTrue()
    {
        // Arrange
        $number1 = new BigNumber('0.123456789');
        $number2 = new BigNumber(2);

        // Act
        $result = Utils::multiply($number1, $number2, 10, true);

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $result);
        $this->assertEquals('0.2469135780', (string)$result);
        $this->assertEquals('0.123456789', $number1);
        $this->assertEquals('2.0000000000', $number2);
        $this->assertTrue($result->isMutable());
    }
}
