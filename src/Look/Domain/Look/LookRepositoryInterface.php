<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Look;

use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;

interface LookRepositoryInterface
{
    /**
     * @param int $id
     * @return LookInterface
     * @throws LookNotFoundException
     */
    public function getById(int $id): LookInterface;
}
