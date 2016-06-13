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

class BigNumberSqrtTest extends PHPUnit_Framework_TestCase
{
    public function testSqrt()
    {
        // Arrange
        $bigNumber = new BigNumber('12345.12345');

        // Act
        $bigNumber->sqrt();

        // Assert
        $this->assertInternalType('string', $bigNumber->getValue());
        $this->assertEquals('111.1086110524', $bigNumber->getValue());
    }

    public function testWithMutableFalse()
    {
        // Arrange
        $bigNumber = new BigNumber('9', 10, false);

        // Act
        $newBigNumber = $bigNumber->sqrt();

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $bigNumber);
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $newBigNumber);
        $this->assertEquals('9', $bigNumber->getValue());
        $this->assertEquals('3', $newBigNumber->getValue());
    }

    public function testWithMutableTrue()
    {
        // Arrange
        $bigNumber = new BigNumber('9', 10, true);

        // Act
        $newBigNumber = $bigNumber->sqrt();

        // Assert
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $bigNumber);
        $this->assertInstanceOf('PHP\Math\BigNumber\BigNumber', $newBigNumber);
        $this->assertEquals('3', $bigNumber->getValue());
        $this->assertEquals('3', $newBigNumber->getValue());
    }
}
