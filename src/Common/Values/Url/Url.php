<?php

declare(strict_types=1);

namespace Raspberry\Common\Values\Url;

use Raspberry\Common\Values\Exceptions\InvalidValueException;

class Url implements UrlInterface
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
     * @inheritDoc
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function validate(string $value): bool
    {
        return (bool) filter_var($value, FILTER_VALIDATE_URL);
    }
}
