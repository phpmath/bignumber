<?php

namespace PHP\Math\BigNumberTest;

use PHP\Math\BigNumber\BigNumber;
use PHPUnit_Framework_TestCase;

class BigNumberDivideTest extends PHPUnit_Framework_TestCase
{
    public function testWithBigNumber()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = new BigNumber('1234567890.1234567890');

        // Act
        $bigNumber->divide($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1.0', $bigNumber->getValue());
    }

    public function testWithFloat()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = 12.34;

        // Act
        $bigNumber->divide($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('100046020.2693238888', $bigNumber->getValue());
    }

    public function testWithInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = 12;

        // Act
        $bigNumber->divide($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('102880657.5102880657', $bigNumber->getValue());
    }

    public function testWithStringFloat()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = '1234567890.1234567890';

        // Act
        $bigNumber->divide($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1.0', $bigNumber->getValue());
    }

    public function testWithStringInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = '1234567890';

        // Act
        $bigNumber->divide($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1.0000000001', $bigNumber->getValue());
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
        $bigNumber->divide($value);

        // Assert
        // ...
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWithZero()
    {
        // Arrange
        $bigNumber = new BigNumber('0');
        $value = '0';

        // Act
        $bigNumber->divide($value);

        // Assert
        // ...
    }

    public function testWithMutableFalse()
    {
        // Arrange
        $bigNumber = new BigNumber('10', 10, false);

        // Act
        $newBigNumber = $bigNumber->divide(10);

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $bigNumber);
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $newBigNumber);
        $this->assertEquals('10', $bigNumber->getValue());
        $this->assertEquals('1', $newBigNumber->getValue());
    }

    public function testWithMutableTrue()
    {
        // Arrange
        $bigNumber = new BigNumber('10', 10, true);

        // Act
        $newBigNumber = $bigNumber->divide(10);

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $bigNumber);
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $newBigNumber);
        $this->assertEquals('1', $bigNumber->getValue());
        $this->assertEquals('1', $newBigNumber->getValue());
    }
}
