<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Keyboards;

trait KeyboardTrait
{
    public function getRows(): array
    {
        return $this->rows;
    }

    public function addRow(...$button): void
    {
        if (count($button) > 0) {
            $this->rows[] = $button;
        }
    }
}
