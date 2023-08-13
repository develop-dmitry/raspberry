<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Context\Request\CallbackData;

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
}
