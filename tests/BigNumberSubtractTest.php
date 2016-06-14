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
use PHPUnit_Framework_TestCase;

class BigNumberSubtractTest extends PHPUnit_Framework_TestCase
{
    public function testWithBigNumber()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = new BigNumber('1234567890.1234567890');

        // Act
        $bigNumber->subtract($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('0', $bigNumber->getValue());
    }

    public function testWithFloat()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = 12.34;

        // Act
        $bigNumber->subtract($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1234567877.7834567890', $bigNumber->getValue());
    }

    public function testWithInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = 12;

        // Act
        $bigNumber->subtract($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1234567878.1234567890', $bigNumber->getValue());
    }

    public function testWithStringFloat()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = '1234567890.1234567890';

        // Act
        $bigNumber->subtract($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('0', $bigNumber->getValue());
    }

    public function testWithStringInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = '1234567890';

        // Act
        $bigNumber->subtract($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('0.1234567890', $bigNumber->getValue());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWithNonNumber()
    {
        // Arrange
        $bigNumber = new BigNumber('0');
        $value = 'abc';

        // Act
        $bigNumber->subtract($value);

        // Assert
        // ...
    }

    public function testWithMutableFalse()
    {
        // Arrange
        $bigNumber = new BigNumber('10', 10, false);

        // Act
        $newBigNumber = $bigNumber->subtract(10);

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $bigNumber);
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $newBigNumber);
        $this->assertEquals('10', $bigNumber->getValue());
        $this->assertEquals('0', $newBigNumber->getValue());
    }

    public function testWithMutableTrue()
    {
        // Arrange
        $bigNumber = new BigNumber('10', 10, true);

        // Act
        $newBigNumber = $bigNumber->subtract(10);

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $bigNumber);
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $newBigNumber);
        $this->assertEquals('0', $bigNumber->getValue());
        $this->assertEquals('0', $newBigNumber->getValue());
    }
}
