<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context\Request\CallbackData;

class NullCallbackData implements CallbackDataInterface
{
    public function __construct(
        protected string $action = '',
        protected array $query = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @inheritDoc
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @inheritDoc
     */
    public function get(string $path, mixed $default = null): mixed
    {
        return $default;
    }

    /**
     * @inheritDoc
     */
    public function has(string $path): bool
    {
        return false;
    }
}
