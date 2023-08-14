<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Domain\User;

use Raspberry\Common\Values\Id\IdInterface;

class User implements UserInterface
{

    /**
     * @param IdInterface $id
     * @param IdInterface|null $telegramId
     */
    public function __construct(
        protected IdInterface $id,
        protected ?IdInterface $telegramId
    ) {
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
