<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Domain\User;

use Raspberry\Common\Values\Id\IdInterface;

class User implements UserInterface
{

    /**
     * @param IdInterface|null $id
     * @param IdInterface|null $telegramId
     */
    protected function __construct(
        protected ?IdInterface $id,
        protected ?IdInterface $telegramId
    ) {
    }

    public static function make(IdInterface $id, ?IdInterface $telegramId): self
    {
        return new User($id, $telegramId);
    }

    public static function register(?IdInterface $telegramId): self
    {
        return new User(null, $telegramId);
    }

    /**
     * @inheritDoc
     */
    public function getId(): IdInterface
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getTelegramId(): ?IdInterface
    {
        return $this->telegramId;
    }
}
