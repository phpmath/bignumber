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

class BigNumberSetScaleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testWithFloat()
    {
        // Arrange
        $bigNumber = new BigNumber('1.234567890');

        // Act
        $bigNumber->setScale(5.5);

        // Assert
        // ...
    }

    public function testWithInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('1.234567890');

        // Act
        $bigNumber->setScale(5);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1.23456', $bigNumber->getValue());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWithStringFloat()
    {
        // Arrange
        $bigNumber = new BigNumber('1.234567890');

        // Act
        $bigNumber->setScale('5.5');

        // Assert
        // ...
    }

    public function testWithStringInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('0');

        // Act
        $bigNumber->setScale('5');

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('0.00000', $bigNumber->getValue());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWithBigNumberNonZeroScale()
    {
        // Arrange
        $bigNumber = new BigNumber('0');
        $bigNumberValue = new BigNumber('2', 2);

        // Act
        $bigNumber->setScale($bigNumberValue);

        // Assert
        // ...
    }

    public function testWithBigNumberZeroScale()
    {
        // Arrange
        $bigNumber = new BigNumber('0', 2);
        $bigNumberValue = new BigNumber('2', 0);

        // Act
        $bigNumber->setScale($bigNumberValue);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('0.00', $bigNumber->getValue());
    }

    /**
     * @expectedException RuntimeException
     */
    public function testWithMutableFalse()
    {
        // Arrange
        $bigNumber = new BigNumber('0', 10, false);

        // Act
        $bigNumber->setScale('2');

        // Assert
        // ...
    }

    public function testWithMutableTrue()
    {
        // Arrange
        $bigNumber = new BigNumber('0', 10, true);

        // Act
        $newBigNumber = $bigNumber->setScale('2');

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $bigNumber);
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $newBigNumber);
        $this->assertEquals('0.00', $bigNumber->getValue());
        $this->assertEquals('0.00', $newBigNumber->getValue());
    }
}
