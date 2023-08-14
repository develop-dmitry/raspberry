<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Domain\User;

use Raspberry\Common\Values\Id\IdInterface;

interface UserInterface
{
    /**
     * @return IdInterface
     */
    public function getId(): IdInterface;

    /**
     * @return IdInterface|null
     */
    public function getTelegramId(): ?IdInterface;
}
