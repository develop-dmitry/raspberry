<?php

declare(strict_types=1);

namespace Raspberry\Common\Values\Temperature;

use Raspberry\Common\Values\Exceptions\InvalidValueException;

class Temperature implements TemperatureInterface
{

    protected int $value;

    /**
     * @param int $value
     * @throws InvalidValueException
     */
    public function __construct(int $value)
    {
        if (!$this->validate($value)) {
            throw new InvalidValueException();
        }

        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): int
    {
        return $this->value;
    }

    protected function validate(int $value): bool
    {
        return $value >= -50 && $value <= 50;
    }
}
