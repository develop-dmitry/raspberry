<?php

namespace Raspberry\Look\Application\PickerScore;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\PickerScore\DTO\PickerScoreRequest;
use Raspberry\Look\Application\PickerScore\DTO\PickerScoreResponse;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface PickerScoreInterface
{

    /**
     * @param PickerScoreRequest $request
     * @return PickerScoreResponse
     * @throws LookNotFoundException
     * @throws UserNotFoundException
     * @throws InvalidValueException
     * @throws UnknownProperties
     */
    public function execute(PickerScoreRequest $request): PickerScoreResponse;
}
