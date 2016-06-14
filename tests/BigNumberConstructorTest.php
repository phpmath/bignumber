<?php

namespace PHP\Math\BigNumberTest;

use PHP\Math\BigNumber\BigNumber;
use PHPUnit_Framework_TestCase;

class BigNumberConstructorTest extends PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        // Arrange
        // ...

        // Act
        $bigNumber = new BigNumber();

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('0', $bigNumber->getValue());
    }

    public function testWithBigNumber()
    {
        // Arrange
        $bigNumberValue = new BigNumber(12345);

        // Act
        $bigNumber = new BigNumber($bigNumberValue);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('12345', $bigNumber->getValue());
    }

    public function testWithFloat()
    {
        // Arrange
        // ...

        // Act
        $bigNumber = new BigNumber(1234567890.123123123);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1234567890.1231', $bigNumber->getValue());
    }

    public function testWithInteger()
    {
        // Arrange
        // ...

        // Act
        $bigNumber = new BigNumber(1234567890);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1234567890', $bigNumber->getValue());
    }

    public function testWithStringFloat()
    {
        // Arrange
        // ...

        // Act
        $bigNumber = new BigNumber('1234567890.123123123');

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1234567890.123123123', $bigNumber->getValue());
    }

    public function testWithStringInteger()
    {
        // Arrange
        // ...

        // Act
        $bigNumber = new BigNumber('1234567890');

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1234567890', $bigNumber->getValue());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWithNonNumber()
    {
        // Arrange
        // ...

        // Act
        new BigNumber('abc');

        // Assert
        // ...
    }

    public function testWithDefaultScale()
    {
        // Arrange
        // ...

        // Act
        $bigNumber = new BigNumber('12345.67890');

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('12345.67890', $bigNumber->getValue());
    }

    public function testWithCustomScale()
    {
        // Arrange
        // ...

        // Act
        $bigNumber = new BigNumber('12345.67890', 2);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('12345.67', $bigNumber->getValue());
    }
}
