<?php

declare(strict_types=1);

namespace Raspberry\Look\Domain\User;

use Raspberry\Core\Values\Id\IdInterface;
use Raspberry\Look\Domain\Style\StyleInterface;

interface UserInterface
{

    /**
     * @return IdInterface
     */
    public function getId(): IdInterface;

    /**
     * @return StyleInterface[]
     */
    public function getStyles(): array;

    /**
     * @param StyleInterface $style
     * @return void
     */
    public function addStyle(StyleInterface $style): void;

    /**
     * @param StyleInterface $style
     * @return void
     */
    public function removeStyle(StyleInterface $style): void;
}
