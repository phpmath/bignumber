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

class BigNumberPowTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testWithBigNumber()
    {
        // Arrange
        $bigNumber = new BigNumber('12345.12345');
        $value = new BigNumber('12');

        // Act
        $bigNumber->pow($value);

        // Assert
        // ...
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
        $bigNumber->pow($value);

        // Assert
        // ...
    }

    public function testWithInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('12345.12345');
        $value = 12;

        // Act
        $bigNumber->pow($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('12529831950385717769202749069405938445346350062072.3461609748', $bigNumber->getValue());
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
        $bigNumber->pow($value);

        // Assert
        // ...
    }

    public function testWithStringInteger()
    {
        // Arrange
        $bigNumber = new BigNumber('12345.12345');
        $value = '12';

        // Act
        $bigNumber->pow($value);

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('12529831950385717769202749069405938445346350062072.3461609748', $bigNumber->getValue());
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
        $bigNumber->pow($value);

        // Assert
        // ...
    }

    public function testWithMutableFalse()
    {
        // Arrange
        $bigNumber = new BigNumber('2', 10, false);

        // Act
        $newBigNumber = $bigNumber->pow(2);

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $bigNumber);
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $newBigNumber);
        $this->assertEquals('2', $bigNumber->getValue());
        $this->assertEquals('4', $newBigNumber->getValue());
    }

    public function testWithMutableTrue()
    {
        // Arrange
        $bigNumber = new BigNumber('2', 10, true);

        // Act
        $newBigNumber = $bigNumber->pow(2);

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $bigNumber);
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $newBigNumber);
        $this->assertEquals('4', $bigNumber->getValue());
        $this->assertEquals('4', $newBigNumber->getValue());
    }
}
