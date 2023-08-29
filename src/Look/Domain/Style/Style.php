<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\Style;

use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Common\Values\Name\NameInterface;
use Raspberry\Look\Domain\Style\StyleInterface;

class Style implements StyleInterface
{

    /**
     * @param IdInterface $id
     * @param NameInterface $name
     */
    public function __construct(
        protected IdInterface $id,
        protected NameInterface $name
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
}
