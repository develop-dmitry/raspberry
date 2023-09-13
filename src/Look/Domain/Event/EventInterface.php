<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Event;

use Raspberry\Core\Values\Id\IdInterface;
use Raspberry\Core\Values\Name\NameInterface;
use Raspberry\Core\Values\Slug\SlugInterface;

interface EventInterface
{

    /**
     * @return IdInterface
     */
    public function getId(): IdInterface;

    /**
     * @return NameInterface
     */
    public function getName(): NameInterface;

    /**
     * @return SlugInterface
     */
    public function getSlug(): SlugInterface;
}
