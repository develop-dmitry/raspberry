<?php

declare(strict_types=1);

namespace Raspberry\Look\Application\SelectionLook\DTO;

class LookItem
{

    /**
     * @param int $id
     * @param string $name
     * @param string $photo
     */
    public function __construct(
        protected int $id,
        protected string $name,
        protected string $photo
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'photo' => $this->getPhoto()
        ];
    }
}
