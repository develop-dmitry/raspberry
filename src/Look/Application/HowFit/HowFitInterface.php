<?php

namespace Raspberry\Look\Application\HowFit;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Exceptions\UserNotFoundException;
use Raspberry\Look\Application\HowFit\DTO\HowFitRequest;
use Raspberry\Look\Application\HowFit\DTO\HowFitResponse;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface HowFitInterface
{

    /**
     * @param HowFitRequest $request
     * @return HowFitResponse
     * @throws LookNotFoundException
     * @throws UserNotFoundException
     * @throws InvalidValueException
     * @throws UnknownProperties
     */
    public function execute(HowFitRequest $request): HowFitResponse;
}
