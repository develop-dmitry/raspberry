<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\SelectionLook;

use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookRequest;
use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookResponse;
use Raspberry\Look\Domain\Event\Exceptions\EventNotFoundException;

interface SelectionLookInterface
{

    /**
     * @param SelectionLookRequest $request
     * @return SelectionLookResponse
     * @throws EventNotFoundException
     * @throws InvalidValueException
     */
    public function execute(SelectionLookRequest $request): SelectionLookResponse;
}
