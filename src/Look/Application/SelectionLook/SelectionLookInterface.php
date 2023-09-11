<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\SelectionLook;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookRequest;
use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface SelectionLookInterface
{

    /**
     * @param SelectionLookRequest $request
     * @return SelectionLookResponse
     * @throws UserNotFoundException
     * @throws InvalidValueException
     * @throws UnknownProperties
     */
    public function execute(SelectionLookRequest $request): SelectionLookResponse;
}
