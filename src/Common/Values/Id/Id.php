<?php

declare(strict_types=1);

namespace Raspberry\Common\Values\Id;

use Raspberry\Common\Values\Exceptions\InvalidValueException;

class Id implements IdInterface
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
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    protected function validate(int $value): bool {
        return $value > 0;
    }
}
