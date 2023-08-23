<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Style;

interface StyleRepositoryInterface
{

    /**
     * @param array $ids
     * @return StyleInterface[]
     */
    public function getCollection(array $ids): array;
}
