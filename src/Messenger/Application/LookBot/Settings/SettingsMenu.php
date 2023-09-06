<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Settings;

enum SettingsMenu
{

    case Styles;

    case Back;

    public function getText(): string
    {
        return match ($this) {
            self::Styles => 'Предпочитаемые стили',
            self::Back => 'Назад'
        };

    }
}
