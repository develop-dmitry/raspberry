<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLookUrl\DTO;

class DetailLookUrlRequest
{

    /**
     * @param int $lookId
     */
    public function __construct(
        protected int $lookId
    ) {
    }

    /**
     * @return int
     */
    public function getLookId(): int
    {
        return $this->lookId;
    }
}
