<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Event;

use Raspberry\Common\Values\Name\NameInterface;
use Raspberry\Common\Values\Slug\SlugInterface;
use Raspberry\Look\Domain\Event\EventInterface;

class Event implements EventInterface
{

    /**
     * @param NameInterface $name
     * @param SlugInterface $slug
     */
    public function __construct(
        protected NameInterface $name,
        protected SlugInterface $slug
    ) {
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
