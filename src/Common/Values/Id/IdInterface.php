<?php

declare(strict_types=1);

namespace Raspberry\Common\Values\Id;

interface IdInterface
{
    /**
     * @return int
     */
    public function getValue(): int;
}
