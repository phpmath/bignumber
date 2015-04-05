<?php

namespace PHP\Math\BigNumberTest;

use PHP\Math\BigNumber\Utils;
use PHPUnit_Framework_TestCase;

class UtilsSetDefaultScaleTest extends PHPUnit_Framework_TestCase
{
    public function testSetDefaultScale()
    {
        // Arrange
        $backup = ini_get('bcmath.scale');

        // Act
        Utils::setDefaultScale($backup + 1);
        $value = ini_get('bcmath.scale');
        ini_set('bcmath.scale', $backup);

        // Assert
        $this->assertEquals($backup + 1, $value);
    }
}
