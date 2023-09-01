<?php

declare(strict_types=1);

namespace Raspberry\Common\Base\Pagination;

interface PaginationInterface
{

    /**
     * @return array
     */
    public function getItems(): array;

    /**
     * @return int
     */
    public function getTotal(): int;

    /**
     * @return int
     */
    public function getPage(): int;

    /**
     * @return int
     */
    public function getPerPage(): int;

    /**
     * @return bool
     */
    public function hasNext(): bool;

    /**
     * @return bool
     */
    public function hasPrev(): bool;
}
