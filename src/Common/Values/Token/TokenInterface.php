<?php

namespace Raspberry\Common\Values\Token;

interface TokenInterface
{

    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @return string
     */
    public function getHashValue(): string;
}
