<?php

namespace PHP\Math\BigNumberTest;

use PHP\Math\BigNumber\BigNumber;
use PHPUnit\Framework\TestCase;

class BigNumberIsMutableTest extends TestCase
{
    public function testIsMutableEmpty()
    {
        // Arrange
        $bigInteger = new BigNumber('123');

        // Act
        $result = $bigInteger->isMutable();

        // Assert
        $this->assertTrue($result);
    }

    public function testIsMutableFalse()
    {
        // Arrange
        $bigInteger = new BigNumber('123', 10, false);

        // Act
        $result = $bigInteger->isMutable();

        // Assert
        $this->assertFalse($result);
    }

    public function testIsMutableTrue()
    {
        // Arrange
        $bigInteger = new BigNumber('123', 10, true);

        // Act
        $result = $bigInteger->isMutable();

        // Assert
        $this->assertTrue($result);
    }
}
