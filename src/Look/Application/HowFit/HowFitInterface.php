<?php

namespace Raspberry\Look\Application\HowFit;

use Raspberry\Common\Exceptions\UserExceptions\UserNotFoundException;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Look\Application\HowFit\DTO\HowFitRequest;
use Raspberry\Look\Application\HowFit\DTO\HowFitResponse;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;

interface HowFitInterface
{

    /**
     * @param HowFitRequest $request
     * @return HowFitResponse
     * @throws LookNotFoundException
     * @throws UserNotFoundException
     * @throws InvalidValueException
     */
    public function execute(HowFitRequest $request): HowFitResponse;
}
