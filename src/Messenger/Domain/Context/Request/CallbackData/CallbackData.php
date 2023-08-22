<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context\Request\CallbackData;

use Illuminate\Database\Eloquent\Casts\Json;

class CallbackData implements CallbackDataInterface
{
    /**
     * @param string $action
     * @param array $query
     */
    protected function __construct(
        protected string $action,
        protected array $query
    ) {
    }

    /**
     * @param string $json
     * @return self
     */
    public static function fromJson(string $json): self
    {
        $decoded = Json::decode($json);
        $action = $decoded['action'] ?? '';
        unset($decoded['action']);

        return new self($action, $decoded);
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
        if (!$this->has($path)) {
            return $default;
        }

        $keys = $this->getKeys($path);
        $value = $this->query;

        foreach ($keys as $key) {
            if (isset($value[$key])) {
                $value = $value[$key];
            }
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function has(string $path): bool
    {
        $keys = $this->getKeys($path);
        $isExists = !empty($keys);
        $array = $this->query;

        foreach ($keys as $key) {
            if (!isset($array[$key])) {
                $isExists = false;
                break;
            }

            $array = $array[$key];
        }

        return $isExists;
    }

    /**
     * @param string $path
     * @return string[]
     */
    protected function getKeys(string $path): array
    {
        return explode('.', $path);
    }
}
