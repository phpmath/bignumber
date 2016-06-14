<?php
/**
 * This file is part of phpmath/bignumber. (https://github.com/phpmath/bignumber)
 *
 * @link https://github.com/phpmath/bignumber for the canonical source repository
 * @copyright Copyright (c) 2015-2016 phpmath. (https://github.com/phpmath/)
 * @license https://raw.githubusercontent.com/phpmath/bignumber/master/LICENSE.md MIT
 */

namespace PHP\Math\BigNumber;

use InvalidArgumentException;
use RuntimeException;

/**
 * A big number value.
 */
class BigNumber
{
    /**
     * The value represented as a string.
     *
     * @var string
     */
    private $value;

    /**
     * The scale that is used.
     *
     * @var int
     */
    private $scale;

    /**
     * A flag that indicates whether or not the state of this object can be changed.
     *
     * @var bool
     */
    private $mutable;

    /**
     * Initializes a new instance of this class.
     *
     * @param string|int|self $value The value to set.
     * @param int $scale The scale to use.
     * @param bool $mutable Whether or not the state of this object can be changed.
     */
    public function __construct($value = 0, $scale = 10, $mutable = true)
    {
        $this->scale = $scale;
        $this->mutable = $mutable;

        $this->internalSetValue($value);
    }

    /**
     * Gets the value of the big number.
     *
     * @return string
     */
    public function getValue()
    {
        // Make sure we return the value with the correct scale:
        return bcadd(0, $this->value, $this->getScale());
    }

    /**
     * Sets the value.
     *
     * @param string $value
     */
    public function setValue($value)
    {
        if (!$this->isMutable()) {
            throw new RuntimeException('Cannot set the value since the number is immutable.');
        }

        return $this->internalSetValue($value);
    }

    /**
     * Gets the scale of this number.
     *
     * @return int
     */
    public function getScale()
    {
        return $this->scale;
    }

    /**
     * Sets the scale of this number.
     *
     * @param int $scale The scale to set.
     * @return BigNumber
     */
    public function setScale($scale)
    {
        if (!$this->isMutable()) {
            throw new RuntimeException(sprintf(
                'Cannot set the scale to "%s" since the numbere is immutable.',
                $scale
            ));
        }

        // Convert to a string to make sure that the __toString method is called for objects.
        $scaleValue = (string)$scale;
        if (!ctype_digit($scaleValue)) {
            throw new InvalidArgumentException(sprintf(
                'Cannot set the scale to "%s". Invalid value.',
                $scaleValue
            ));
        }

        $this->scale = (int)$scaleValue;

        return $this;
    }

    /**
     * Converts the number to an absolute value.
     */
    public function abs()
    {
        $newValue = ltrim($this->getValue(), '-');

        return $this->assignValue($newValue);
    }

    /**
     * Adds the given value to this value.
     *
     * @param float|int|string|BigNumber $value The value to add.
     * @return BigNumber
     */
    public function add($value)
    {
        if (!$value instanceof self) {
            $value = new self($value, $this->getScale(), false);
        }

        $newValue = bcadd($this->getValue(), $value->getValue(), $this->getScale());

        return $this->assignValue($newValue);
    }

    /**
     * Divides this value by the given value.
     *
     * @param float|int|string|BigNumber $value The value to divide by.
     * @return BigNumber
     */
    public function divide($value)
    {
        if (!$value instanceof self) {
            $value = new self($value, $this->getScale(), false);
        }

        $rawValue = $value->getValue();
        if ($rawValue == 0) {
            throw new InvalidArgumentException('Cannot divide by zero.');
        }

        $newValue = bcdiv($this->getValue(), $rawValue, $this->getScale());

        return $this->assignValue($newValue);
    }

    /**
     * Multiplies the given value with this value.
     *
     * @param float|int|string|BigNumber $value The value to multiply with.
     * @return BigNumber
     */
    public function multiply($value)
    {
        if (!$value instanceof self) {
            $value = new self($value, $this->getScale(), false);
        }

        $newValue = bcmul($this->getValue(), $value->getValue(), $this->getScale());

        return $this->assignValue($newValue);
    }

    /**
     * Performs a modulo operation with the given number.
     *
     * @param float|int|string|BigNumber $value The value to perform a modulo operation with.
     * @return BigNumber
     */
    public function mod($value)
    {
        $bigNumber = new self($value, 0, false);

        $newValue = bcmod($this->getValue(), $bigNumber->getValue());

        return $this->assignValue($newValue);
    }

    /**
     * Performs a power operation with the given number.
     *
     * @param int|string $value The value to perform a power operation with. Should be an integer (or an int-string).
     * @return BigNumber
     */
    public function pow($value)
    {
        if (!is_int($value) && !ctype_digit($value)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid exponent "%s" provided. Only integers are allowed.',
                $value
            ));
        }

        $newValue = bcpow($this->getValue(), $value, $this->getScale());

        return $this->assignValue($newValue);
    }

    /**
     * Performs a square root operation with the given number.
     *
     * @return BigNumber
     */
    public function sqrt()
    {
        $newValue = bcsqrt($this->getValue(), $this->getScale());

        return $this->assignValue($newValue);
    }

    /**
     * Subtracts the given value from this value.
     *
     * @param float|int|string|BigNumber $value The value to subtract.
     * @return BigNumber
     */
    public function subtract($value)
    {
        if (!$value instanceof self) {
            $value = new self($value, $this->getScale(), false);
        }

        $newValue = bcsub($this->getValue(), $value->getValue(), $this->getScale());

        return $this->assignValue($newValue);
    }

    /**
     * Checks if this object is mutable.
     *
     * @return bool
     */
    public function isMutable()
    {
        return $this->mutable;
    }

    /**
     * Converts this class to a string.
     *
     * @return string
     */
    public function toString()
    {
        return $this->getValue();
    }

    /**
     * Converts this class to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * A helper method to assign the given value.
     *
     * @param int|string|BigNumber $value The value to assign.
     * @return BigNumber
     */
    private function assignValue($value)
    {
        if ($this->isMutable()) {
            $result = $this->internalSetValue($value);
        } else {
            $result = new BigNumber($value, $this->getScale(), false);
        }

        return $result;
    }

    /**
     * A helper method to set the value on this class.
     *
     * @param int|string|BigNumber $value The value to assign.
     * @return BigNumber
     */
    private function internalSetValue($value)
    {
        if (is_float($value)) {
            $valueToSet = Utils::convertExponentialToString($value);
        } else {
            $valueToSet = (string)$value;
        }

        if (!is_numeric($valueToSet)) {
            throw new InvalidArgumentException('Invalid number provided: ' . $valueToSet);
        }

        // We use a slick trick to make sure the scale is respected.
        $this->value = bcadd(0, $valueToSet, $this->getScale());

        return $this;
    }
}
