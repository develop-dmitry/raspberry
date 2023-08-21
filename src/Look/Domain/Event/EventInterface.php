<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Event;

use Raspberry\Common\Values\Name\NameInterface;
use Raspberry\Common\Values\Slug\SlugInterface;

interface EventInterface
{

    /**
     * @return NameInterface
     */
    public function getName(): NameInterface;

    /**
     * @return SlugInterface
     */
    public function getSlug(): SlugInterface;
}
