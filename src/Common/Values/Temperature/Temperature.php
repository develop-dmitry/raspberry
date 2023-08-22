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

    protected function validate(int|string $value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        $value = (int) $value;

        return $value >= -50 && $value <= 50;
    }
}
