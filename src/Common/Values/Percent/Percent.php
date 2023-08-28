<?php

namespace Raspberry\Common\Values\Percent;

use Raspberry\Common\Values\Exceptions\InvalidValueException;

class Percent implements PercentInterface
{

    protected int $value;

    /**
     * @param float $value
     * @throws InvalidValueException
     */
    public function __construct(float $value)
    {
        $this->validate($value);

        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return void
     * @throws InvalidValueException
     */
    protected function validate(float $value): void
    {
        if ($value < 0) {
            throw new InvalidValueException();
        }

        if ($value > 100) {
            throw new InvalidValueException();
        }
    }

    /**
     * @return self
     */
    public static function max(): self
    {
        return new Percent(100);
    }

    /**
     * @param float $decimal
     * @return self
     * @throws InvalidValueException
     */
    public static function fromDecimal(float $decimal): self
    {
        return new Percent($decimal * 100);
    }
}
