<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\DetailLook;

use Raspberry\Look\Application\DetailLook\DTO\DetailLookRequest;
use Raspberry\Look\Application\DetailLook\DTO\DetailLookResponse;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;

interface DetailLookInterface
{
    /**
     * @param DetailLookRequest $request
     * @return DetailLookResponse
     * @throws LookNotFoundException
     */
    public function execute(DetailLookRequest $request): DetailLookResponse;
}
