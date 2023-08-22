<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Handlers\Container;

use Raspberry\Messenger\Domain\Handlers\Container\Exceptions\HandlerNotFoundException;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerType;

interface HandlerContainerInterface
{
    /**
     * @param string $name
     * @param HandlerType $type
     * @param HandlerInterface $handler
     * @return self
     */
    public function addHandler(string $name, HandlerType $type, HandlerInterface $handler): self;

    /**
     * @param string $name
     * @param HandlerType $type
     * @return HandlerInterface
     * @throws HandlerNotFoundException
     */
    public function getHandler(string $name, HandlerType $type): HandlerInterface;

    /**
     * @param HandlerType $type
     * @return HandlerInterface[]
     */
    public function filterByType(HandlerType $type): array;
}
