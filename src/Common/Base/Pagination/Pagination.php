<?php

declare(strict_types=1);

namespace Raspberry\Common\Base\Pagination;

class Pagination implements PaginationInterface
{

    /**
     * @param array $items
     * @param int $total
     * @param int $page
     * @param int $perPage
     */
    public function __construct(
        protected array $items,
        protected int $total,
        protected int $page,
        protected int $perPage
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @inheritDoc
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @inheritDoc
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @inheritDoc
     */
    public function hasNext(): bool
    {
        return $this->page < $this->total;
    }

    /**
     * @inheritDoc
     */
    public function hasPrev(): bool
    {
        return $this->page > 1;
    }
}
