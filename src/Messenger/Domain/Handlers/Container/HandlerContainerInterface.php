<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Handlers\Container;

use Raspberry\Messenger\Domain\Handlers\Container\Exceptions\HandlerNotFoundException;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerTypeEnum;

interface HandlerContainerInterface
{
    /**
     * @param string $name
     * @param HandlerTypeEnum $type
     * @param HandlerInterface $handler
     * @return self
     */
    public function addHandler(string $name, HandlerTypeEnum $type, HandlerInterface $handler): self;

    /**
     * @param string $name
     * @param HandlerTypeEnum $type
     * @return HandlerInterface
     * @throws HandlerNotFoundException
     */
    public function getHandler(string $name, HandlerTypeEnum $type): HandlerInterface;

    /**
     * @param HandlerTypeEnum $type
     * @return HandlerInterface[]
     */
    public function filterByType(HandlerTypeEnum $type): array;
}
