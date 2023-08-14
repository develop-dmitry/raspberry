<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context;

use Raspberry\Messenger\Domain\Context\Request\RequestInterface;
use Raspberry\Messenger\Domain\Context\User\UserInterface;

class Context implements ContextInterface
{
    /**
     * @param RequestInterface $request
     * @param UserInterface|null $user
     */
    public function __construct(
        protected RequestInterface $request,
        protected ?UserInterface $user
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @inheritDoc
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }
}
