<?php

namespace Raspberry\Common\Values\Token;

class Token implements TokenInterface
{

    protected string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value) {
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
     * @inheritDoc
     */
    public function getHashValue(): string
    {
        return hash('sha256', $this->value);
    }
}
