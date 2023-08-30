<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Domain\User;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Common\Values\Token\TokenInterface;

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

    /**
     * @return TokenInterface
     */
    public function getApiToken(): TokenInterface;
}
