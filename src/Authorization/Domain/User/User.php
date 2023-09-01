<?php

declare(strict_types=1);

namespace Raspberry\Authorization\Domain\User;

use Illuminate\Support\Str;
use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Common\Values\Token\Token;
use Raspberry\Common\Values\Token\TokenInterface;

class User implements UserInterface
{

    /**
     * @param IdInterface|null $id
     * @param IdInterface|null $telegramId
     * @param TokenInterface $apiToken
     */
    protected function __construct(
        protected ?IdInterface $id,
        protected ?IdInterface $telegramId,
        protected TokenInterface $apiToken
    ) {
    }

    /**
     * @param IdInterface $id
     * @param IdInterface|null $telegramId
     * @param TokenInterface $token
     * @return self
     */
    public static function make(IdInterface $id, ?IdInterface $telegramId, TokenInterface $token): self
    {
        return new User($id, $telegramId, $token);
    }

    /**
     * @param IdInterface|null $telegramId
     * @return self
     */
    public static function register(?IdInterface $telegramId): self
    {
        return new User(null, $telegramId, self::generateApiToken());
    }

    /**
     * @return TokenInterface
     */
    protected static function generateApiToken(): TokenInterface
    {
        return new Token(Str::random(32));
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

    /**
     * @inheritDoc
     */
    public function getApiToken(): TokenInterface
    {
        return $this->apiToken;
    }
}
