<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Enums;

enum Menu
{

    case SelectionLook;

    public function getText(): string
    {
        switch ($this) {
            case self::SelectionLook:
                return 'Подобрать образ';
        }

        return 'Без названия';
    }
}
