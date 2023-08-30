<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLookUrl\DTO;

class DetailLookUrlRequest
{

    /**
     * @param int $lookId
     * @param array $query
     */
    public function __construct(
        protected int $lookId,
        protected array $query = []
    ) {
    }

    /**
     * @return int
     */
    public function getLookId(): int
    {
        return $this->lookId;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }
}
