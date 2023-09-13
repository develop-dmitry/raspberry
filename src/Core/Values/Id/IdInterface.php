<?php

declare(strict_types=1);

namespace Raspberry\Core\Values\Id;

interface IdInterface
{
    /**
     * @return int
     */
    public function getValue(): int;
}
