<?php

declare(strict_types=1);

namespace Raspberry\Common\Base;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Predis\Client;
use RedisException;

abstract class AbstractRedisRepository
{

    protected string $name = 'base';

    protected string $servicePrefix = 'raspberry_database_';

    protected Client $redis;

    public function __construct()
    {
        $this->redis = Redis::client();
    }

    /**
     * @param int $id
     * @param array $values
     * @return void
     * @throws RedisException
     */
    protected function saveValues(int $id, array $values): void
    {
        foreach ($values as $name => $value) {
            $this->saveValue($id, $name, $value);
        }
    }

    /**
     * @throws RedisException
     */
    protected function saveValue(int $id, string $name, mixed $value): void
    {
        $key = $this->path($id, $name);
        $this->redis->set($key, $value);
    }

    /**
     * @param array $keys
     * @return array
     * @throws RedisException
     */
    protected function getValues(array $keys): array
    {
        $values = [];

        foreach ($keys as $key) {
            $name = $this->getPropertyName($key);
            $values[$name] = $this->getValue($key);
        }

        return $values;
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     * @throws RedisException
     */
    protected function getValue(string $key, mixed $default = null): mixed
    {
        $value = $this->redis->get($key);

        return $value ?: $default;
    }

    /**
     * @param int $id
     * @param string $property
     * @return string
     */
    protected function path(int $id, string $property = '*'): string
    {
        return Str::replace(['{id}', '{property}'], [$id, $property], $this->pattern());
    }

    /**
     * @return string
     */
    private function pattern(): string
    {
        return "$this->name:{id}:{property}";
    }

    /**
     * @param string $pattern
     * @return array
     * @throws RedisException
     */
    protected function keys(string $pattern): array
    {
        $keys = $this->redis->keys($pattern);

        return array_map(fn (string $key) => Str::replace($this->servicePrefix, '', $key), $keys);
    }

    /**
     * @param string $pattern
     * @return string
     */
    protected function getPropertyName(string $pattern): string
    {
        $clearPattern = Str::replace($this->servicePrefix, '', $pattern);
        $parts = explode(':', $clearPattern);

        return $parts[2] ?? '';
    }
}
