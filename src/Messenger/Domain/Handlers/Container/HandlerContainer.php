<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Handlers\Container;

use Raspberry\Messenger\Domain\Handlers\Container\Exceptions\HandlerNotFoundException;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerType;

class HandlerContainer implements HandlerContainerInterface
{
    /**
     * @var HandlerInterface[][]
     */
    protected array $handlers = [];

    /**
     * @inheritDoc
     */
    public function addHandler(string $name, HandlerType $type, HandlerInterface $handler): self
    {
        $this->handlers[$type->value][$name] = $handler;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHandler(string $name, HandlerType $type): HandlerInterface
    {
        if (!isset($this->handlers[$type->value][$name])) {
            throw new HandlerNotFoundException();
        }

        return $this->handlers[$type->value][$name];
    }

    /**
     * @inheritDoc
     */
    public function filterByType(HandlerType $type): array
    {
        return $this->handlers[$type->value] ?? [];
    }
}
