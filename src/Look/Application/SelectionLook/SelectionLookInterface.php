<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\SelectionLook;

use Raspberry\Common\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookRequest;
use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookResponse;

interface SelectionLookInterface
{

    /**
     * @param SelectionLookRequest $request
     * @return SelectionLookResponse
     * @throws UserNotFoundException
     * @throws InvalidValueException
     */
    public function execute(SelectionLookRequest $request): SelectionLookResponse;
}
