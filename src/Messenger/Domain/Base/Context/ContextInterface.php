<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Context;

use Raspberry\Messenger\Domain\Base\Context\Request\RequestInterface;
use Raspberry\Messenger\Domain\Base\Context\User\UserInterface;

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
