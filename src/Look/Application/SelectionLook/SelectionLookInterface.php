<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\SelectionLook;

use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookRequest;
use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookResponse;

interface SelectionLookInterface
{

    /**
     * @param SelectionLookRequest $request
     * @return SelectionLookResponse
     */
    public function execute(SelectionLookRequest $request): SelectionLookResponse;
}
