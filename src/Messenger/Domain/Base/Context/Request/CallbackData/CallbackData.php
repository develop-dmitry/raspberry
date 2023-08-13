<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Context\Request\CallbackData;

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
        $keys = explode('.', $path);
        $value = $this->query;

        foreach ($keys as $key) {
            if (isset($value[$key])) {
                $value = $value[$key];
            } else {
                return $default;
            }
        }

        return $value;
    }
}
