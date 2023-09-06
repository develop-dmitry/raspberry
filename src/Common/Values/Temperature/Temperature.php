<?php

declare(strict_types=1);

namespace Raspberry\Common\Values\Temperature;

use Raspberry\Common\Values\Exceptions\InvalidValueException;

class Temperature implements TemperatureInterface
{

    protected int $value;

    /**
     * @param int|string $value
     * @throws InvalidValueException
     */
    public function __construct(int|string $value)
    {
        if (!$this->validate($value)) {
            throw new InvalidValueException();
        }

        $this->value = (int) $value;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function getCelsius(): string
    {
        $sign = '';

        if ($this->getValue() < 0) {
            $sign = '-';
        } else if ($this->getValue() > 0) {
            $sign = '+';
        }

        $value = abs($this->getValue());

        return "$sign{$value}°C";
    }

    protected function validate(int|string $value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        $value = (int) $value;

        return $value >= -50 && $value <= 50;
    }
}
