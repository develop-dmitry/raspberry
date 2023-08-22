<?php

declare(strict_types=1);

namespace Raspberry\Look\Infrastructure\Repositories;

use Raspberry\Common\Base\AbstractRedisRepository;
use Raspberry\Look\Domain\Look\Services\SelectionLook\Exceptions\FailedSavePropertyException;
use Raspberry\Look\Domain\Look\Services\SelectionLook\SelectionLookRepositoryInterface;
use RedisException;

final class SelectionLookRepository extends AbstractRedisRepository implements SelectionLookRepositoryInterface
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
    public function getMinTemperature(): ?int
    {
        $value = $this->getValue($this->path($this->userId, 'min_temperature'));

        return $value ? (int) $value : null;
    }

    /**
     * @inheritDoc
     */
    public function getMaxTemperature(): ?int
    {
        $value = $this->getValue($this->path($this->userId, 'max_temperature'));

        return $value ? (int) $value : null;
    }

    /**
     * @inheritDoc
     */
    public function getEventId(): ?int
    {
        $value = $this->getValue($this->path($this->userId, 'event_id'));

        return $value ? (int) $value : null;
    }

    /**
     * @inheritDoc
     */
    public function setMinTemperature(int $minTemperature): void
    {
        $this->saveValue($this->userId, 'min_temperature', $minTemperature);
    }

    /**
     * @inheritDoc
     */
    public function setMaxTemperature(int $maxTemperature): void
    {
        $this->saveValue($this->userId, 'max_temperature', $maxTemperature);
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
