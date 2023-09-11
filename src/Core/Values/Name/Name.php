<?php

declare(strict_types=1);

namespace Raspberry\Core\Values\Name;

use Raspberry\Core\Values\Exceptions\InvalidValueException;

class Name implements NameInterface
{
    protected string $value;

    /**
     * @param string $value
     * @throws InvalidValueException
     */
    public function __construct(string $value)
    {
        if (!$this->validate($value)) {
            throw new InvalidValueException();
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    protected function validate(string $name): bool
    {
        return $name !== '';
    }
}
