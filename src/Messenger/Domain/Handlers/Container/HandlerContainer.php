<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Handlers\Container;

use Raspberry\Messenger\Domain\Handlers\Container\Exceptions\HandlerNotFoundException;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerTypeEnum;

class HandlerContainer implements HandlerContainerInterface
{
    /**
     * @var HandlerInterface[][]
     */
    protected array $handlers = [];

    /**
     * @inheritDoc
     */
    public function addHandler(string $name, HandlerTypeEnum $type, HandlerInterface $handler): self
    {
        $this->handlers[$type->value][$name] = $handler;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHandler(string $name, HandlerTypeEnum $type): HandlerInterface
    {
        if (!isset($this->handlers[$type->value][$name])) {
            throw new HandlerNotFoundException();
        }

        return $this->handlers[$type->value][$name];
    }

    /**
     * @inheritDoc
     */
    public function filterByType(HandlerTypeEnum $type): array
    {
        return $this->handlers[$type->value] ?? [];
    }
}
