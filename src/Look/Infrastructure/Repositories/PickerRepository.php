<?php

declare(strict_types=1);

namespace Raspberry\Look\Infrastructure\Repositories;

use Raspberry\Core\Repositories\AbstractRedisRepository;
use Raspberry\Look\Domain\Look\Services\Picker\Exceptions\FailedSavePropertyException;
use Raspberry\Look\Domain\Look\Services\Picker\PickerRepositoryInterface;
use RedisException;

final class PickerRepository extends AbstractRedisRepository implements PickerRepositoryInterface
{

    protected string $name = 'look_selection';

    public function __construct(
        protected int $userId
    ) {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function getTemperature(): ?int
    {
        $value = $this->getValue($this->path($this->userId, 'temperature'));

        return $value === null ? null : (int) $value;
    }

    /**
     * @inheritDoc
     */
    public function getEventId(): ?int
    {
        $value = $this->getValue($this->path($this->userId, 'event_id'));

        return $value === null ? null : (int) $value;
    }

    /**
     * @inheritDoc
     */
    public function setTemperature(int $temperature): void
    {
        $this->saveValue($this->userId, 'temperature', $temperature);
    }

    /**
     * @inheritDoc
     */
    public function setEventId(int $eventId): void
    {
        $this->saveValue($this->userId, 'event_id', $eventId);
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    protected function getValue(string $key, mixed $default = null): mixed
    {
        try {
            return parent::getValue($key, $default);
        } catch (RedisException) {
            return $default;
        }
    }

    /**
     * @param int $id
     * @param string $name
     * @param mixed $value
     * @return void
     * @throws FailedSavePropertyException
     */
    protected function saveValue(int $id, string $name, mixed $value): void
    {
        try {
            parent::saveValue($id, $name, $value);
        } catch (RedisException $exception) {
            throw new FailedSavePropertyException($exception->getMessage());
        }
    }
}
