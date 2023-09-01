<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Style;

use Raspberry\Common\Base\Pagination\PaginationInterface;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Domain\Style\Exceptions\StyleNotFoundException;

interface StyleRepositoryInterface
{

    /**
     * @param array $ids
     * @return StyleInterface[]
     */
    public function getCollection(array $ids): array;

    /**
     * @param int $id
     * @return StyleInterface
     * @throws StyleNotFoundException
     * @throws InvalidValueException
     */
    public function getById(int $id): StyleInterface;

    /**
     * @param int $page
     * @param int $perPage
     * @return PaginationInterface
     */
    public function paginate(int $page, int $perPage): PaginationInterface;
}
