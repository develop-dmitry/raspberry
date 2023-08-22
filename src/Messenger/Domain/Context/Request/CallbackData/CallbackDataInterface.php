<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context\Request\CallbackData;

interface CallbackDataInterface
{
    /**
     * @return string
     */
    public function getAction(): string;

    /**
     * @return array
     */
    public function getQuery(): array;

    /**
     * @param string $path
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $path, mixed $default = null): mixed;

    /**
     * @param string $path
     * @return bool
     */
    public function has(string $path): bool;
}
