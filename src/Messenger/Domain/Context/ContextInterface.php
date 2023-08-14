<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context;

use Raspberry\Messenger\Domain\Context\Request\RequestInterface;
use Raspberry\Messenger\Domain\Context\User\UserInterface;

interface ContextInterface
{
    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface;

    /**
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface;
}
