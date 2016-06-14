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

class BigNumberSetValueTest extends PHPUnit_Framework_TestCase
{
    public function testWithInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('0');

        // Act
        $bigNumber->setValue(123);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('123', $bigNumber->getValue());
    }

    public function testWithString()
    {
        // Arrange
        $bigNumber = new BigNumber('0');

        // Act
        $bigNumber->setValue('123');

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('123', $bigNumber->getValue());
    }

    public function testWithBigNumber()
    {
        // Arrange
        $bigNumber = new BigNumber('0');
        $bigNumberValue = new BigNumber('123');

        // Act
        $bigNumber->setValue($bigNumberValue);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('123', $bigNumber->getValue());
    }

    /**
     * @expectedException RuntimeException
     */
    public function testWithMutableFalse()
    {
        // Arrange
        $bigNumber = new BigNumber('0', 10, false);

        // Act
        $bigNumber->setValue('123');

        // Assert
        // ...
    }

    public function testWithMutableTrue()
    {
        // Arrange
        $bigNumber = new BigNumber('0', 10, true);

        // Act
        $newBigNumber = $bigNumber->setValue('123');

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $bigNumber);
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $newBigNumber);
        $this->assertEquals('123', $bigNumber->getValue());
        $this->assertEquals('123', $newBigNumber->getValue());
    }
}
