<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Event;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Common\Values\Name\NameInterface;
use Raspberry\Common\Values\Slug\SlugInterface;
use Raspberry\Look\Domain\Event\EventInterface;

class Event implements EventInterface
{

    /**
     * @param IdInterface $id
     * @param NameInterface $name
     * @param SlugInterface $slug
     */
    public function __construct(
        protected IdInterface $id,
        protected NameInterface $name,
        protected SlugInterface $slug
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
    public function getName(): NameInterface
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getSlug(): SlugInterface
    {
        return $this->slug;
    }
}
