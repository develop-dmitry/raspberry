<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Enums;

enum Menu
{

    case SelectionLook;

    case Wardrobe;

    case Settings;

    public function getText(): string
    {
        return match ($this) {
            self::SelectionLook => 'Подобрать образ',
            self::Wardrobe => 'Гардероб',
            self::Settings => 'Настройки'
        };
    }
}
