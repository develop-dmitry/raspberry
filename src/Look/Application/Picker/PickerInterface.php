<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\Picker;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\Picker\DTO\PickerRequest;
use Raspberry\Look\Application\Picker\DTO\PickerResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface PickerInterface
{

    /**
     * @param PickerRequest $request
     * @return PickerResponse
     * @throws UserNotFoundException
     * @throws InvalidValueException
     * @throws UnknownProperties
     */
    public function execute(PickerRequest $request): PickerResponse;
}
