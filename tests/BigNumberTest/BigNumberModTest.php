<?php

namespace PHP\Math\BigNumberTest;

use PHP\Math\BigNumber\BigNumber;
use PHPUnit_Framework_TestCase;

class BigNumberModTest extends PHPUnit_Framework_TestCase
{
    public function testWithBigNumber()
    {
        // Arrange
        $bigNumber = new BigNumber('12345.12345');
        $value = new BigNumber('12');

        // Act
        $bigNumber->mod($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('9', $bigNumber->getValue());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWithFloat()
    {
        // Arrange
        $bigNumber = new BigNumber('12345');
        $value = 12.34;

        // Act
        $bigNumber->mod($value);

        // Assert
        // ...
    }

    public function testWithInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('12345.12345');
        $value = 12;

        // Act
        $bigNumber->mod($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('9', $bigNumber->getValue());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWithStringFloat()
    {
        // Arrange
        $bigNumber = new BigNumber('1234567890.1234567890');
        $value = '1234567890.1234567890';

        // Act
        $bigNumber->mod($value);

        // Assert
        // ...
    }

    public function testWithStringInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('12345.12345');
        $value = '12';

        // Act
        $bigNumber->mod($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('9', $bigNumber->getValue());
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
        $bigNumber->mod($value);

        // Assert
        // ...
    }
}
