<?php

namespace PHP\Math\BigNumberTest;

use PHP\Math\BigNumber\BigNumber;
use PHPUnit_Framework_TestCase;

class BigNumberAddTest extends PHPUnit_Framework_TestCase
{
    public function testWithBigNumber()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = new BigNumber('1234567890.1234567890');

        // Act
        $bigNumber->add($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('2469135780.2469135780', $bigNumber->getValue());
    }

    public function testWithFloat()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = 12.34;

        // Act
        $bigNumber->add($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1234567902.4634567890', $bigNumber->getValue());
    }

    public function testWithInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = 12;

        // Act
        $bigNumber->add($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('1234567902.1234567890', $bigNumber->getValue());
    }

    public function testWithStringFloat()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = '1234567890.1234567890';

        // Act
        $bigNumber->add($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('2469135780.2469135780', $bigNumber->getValue());
    }

    public function testWithStringInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = '1234567890';

        // Act
        $bigNumber->add($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('2469135780.1234567890', $bigNumber->getValue());
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
        $bigNumber->add($value);

        // Assert
        // ...
    }

    public function testWithMutableFalse()
    {
        // Arrange
        $bigNumber = new BigNumber('0', 10, false);

        // Act
        $newBigNumber = $bigNumber->add(10);

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $bigNumber);
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $newBigNumber);
        $this->assertEquals('0', $bigNumber->getValue());
        $this->assertEquals('10', $newBigNumber->getValue());
    }

    public function testWithMutableTrue()
    {
        // Arrange
        $bigNumber = new BigNumber('0', 10, true);

        // Act
        $newBigNumber = $bigNumber->add(10);

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $bigNumber);
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $newBigNumber);
        $this->assertEquals('10', $bigNumber->getValue());
        $this->assertEquals('10', $newBigNumber->getValue());
    }
}
