<?php

namespace PHP\Math\BigNumber;

use InvalidArgumentException;

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
     * Initializes a new instance of this class.
     *
     * @param string|int|self $value The value to set.
     */
    public function __construct($value = 0)
    {
        bcscale(10);

        $this->setValue($value);
    }

    /**
     * Gets the value of the big number.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value.
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->checkValue($value);

        $this->value = $value;

        return $this;
    }

    /**
     * Converts the number to an absolute value.
     */
    public function abs()
    {
        $this->setValue(ltrim($this->getValue(), '-'));

        return $this;
    }

    /**
     * Adds the given value to this value.
     *
     * @param float|int|string|BigNumber $value The value to add.
     */
    public function add($value)
    {
        if (!$value instanceof self) {
            $value = new self($value);
        }

        $newValue = bcadd($this->getValue(), $value->getValue());

        $this->setValue($newValue);

        return $this;
    }

    /**
     * Divides this value by the given value.
     *
     * @param float|int|string|BigNumber $value The value to divide by.
     */
    public function divide($value)
    {
        if (!$value instanceof self) {
            $value = new self($value);
        }

        $rawValue = $value->getValue();
        if (empty($rawValue)) {
            throw new InvalidArgumentException('Cannot divide by zero.');
        }

        $newValue = bcdiv($this->getValue(), $rawValue);

        $this->setValue($newValue);

        return $this;
    }

    /**
     * Multiplies the given value with this value.
     *
     * @param float|int|string|BigNumber $value The value to multiply with.
     */
    public function multiply($value)
    {
        if (!$value instanceof self) {
            $value = new self($value);
        }

        $newValue = bcmul($this->getValue(), $value->getValue());

        $this->setValue($newValue);

        return $this;
    }

    /**
     * Performs a modulo operation with the given number.
     *
     * @param float|int|string|BigNumber $value The value to perform a modulo operation with.
     */
    public function mod($value)
    {
        if (!$value instanceof self) {
            $value = new self($value);
        }

        if (!ctype_digit($value->getValue())) {
            throw new InvalidArgumentException('Invalid exponent provided. Only integers are allowed.');
        }

        $newValue = bcmod($this->getValue(), $value->getValue());

        $this->setValue($newValue);

        return $this;
    }

    /**
     * Performs a power operation with the given number.
     *
     * @param float|int|string|BigNumber $value The value to perform a power operation with.
     */
    public function pow($value)
    {
        if (!$value instanceof self) {
            $value = new self($value);
        }

        if (!ctype_digit($value->getValue())) {
            throw new InvalidArgumentException('Invalid exponent provided. Only integers are allowed.');
        }

        $newValue = bcpow($this->getValue(), $value->getValue());

        $this->setValue($newValue);

        return $this;
    }

    /**
     * Performs a square root operation with the given number.
     *
     * @param float|int|string|BigNumber $value The value to perform a square root operation with.
     */
    public function sqrt($value)
    {
        if (!$value instanceof self) {
            $value = new self($value);
        }

        if (!ctype_digit($value->getValue())) {
            throw new InvalidArgumentException('Invalid exponent provided. Only integers are allowed.');
        }

        $newValue = bcsqrt($this->getValue(), $value->getValue());

        $this->setValue($newValue);

        return $this;
    }

    /**
     * Subtracts the given value from this value.
     *
     * @param float|int|string|BigNumber $value The value to subtract.
     */
    public function subtract($value)
    {
        if (!$value instanceof self) {
            $value = new self($value);
        }

        $newValue = bcsub($this->getValue(), $value->getValue());

        $this->setValue($newValue);

        return $this;
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
     * Checks if the given value is valid.
     *
     * @param int|string $value The value to check.
     * @throws InvalidArgumentException Thrown when the value is invalid.
     */
    private function checkValue(&$value)
    {
        $value = (string)$value;

        if (!is_numeric($value)) {
            throw new InvalidArgumentException('Invalid number provided: ' . $value);
        }
    }
}
