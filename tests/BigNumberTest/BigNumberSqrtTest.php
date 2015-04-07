<?php

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
}
