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
}
