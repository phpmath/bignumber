<?php

namespace PHP\Math\BigNumberTest;

use PHP\Math\BigNumber\BigNumber;
use PHPUnit_Framework_TestCase;

class BigNumberAbsTest extends PHPUnit_Framework_TestCase
{
    public function testWithNegativeFloat()
    {
        // Arrange
        $bigNumber = new BigNumber('-1234567890.1234567890');

        // Act
        $bigNumber->abs();

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1234567890.1234567890', $bigNumber->getValue());
    }

    public function testWithPositiveFloat()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');

        // Act
        $bigNumber->abs();

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1234567890.1234567890', $bigNumber->getValue());
    }

    public function testWithNegativeInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('-1234567890');

        // Act
        $bigNumber->abs();

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1234567890', $bigNumber->getValue());
    }

    public function testWithPositiveInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890');

        // Act
        $bigNumber->abs();

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1234567890', $bigNumber->getValue());
    }

    public function testWithMutableFalse()
    {
        // Arrange
        $bigNumber = new BigNumber('-5', 10, false);

        // Act
        $newBigNumber = $bigNumber->abs();

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $bigNumber);
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $newBigNumber);
        $this->assertEquals('-5', $bigNumber->getValue());
        $this->assertEquals('5', $newBigNumber->getValue());
    }

    public function testWithMutableTrue()
    {
        // Arrange
        $bigNumber = new BigNumber('-5', 10, true);

        // Act
        $newBigNumber = $bigNumber->abs();

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $bigNumber);
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $newBigNumber);
        $this->assertEquals('5', $bigNumber->getValue());
        $this->assertEquals('5', $newBigNumber->getValue());
    }
}
