<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Style;

use Raspberry\Core\Values\Id\IdInterface;
use Raspberry\Core\Values\Name\NameInterface;

interface StyleInterface
{

    /**
     * @return IdInterface
     */
    public function getId(): IdInterface;

    /**
     * @return NameInterface
     */
    public function getName(): NameInterface;
}
