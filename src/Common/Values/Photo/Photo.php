<?php

declare(strict_types=1);

namespace Raspberry\Common\Values\Photo;

use Raspberry\Common\Values\Exceptions\InvalidValueException;

class Photo implements PhotoInterface
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

    protected function validate(string $value): bool
    {
        return $value !== '';
    }
}
