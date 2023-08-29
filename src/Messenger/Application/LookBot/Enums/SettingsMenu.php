<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Enums;

enum SettingsMenu
{

    case Styles;

    case Back;

    public function getText(): string
    {
        switch ($this) {
            case self::Styles:
                return 'Предпочитаемые стили';
            case self::Back:
                return 'Назад';
        }

        return 'Без названия';
    }
}
