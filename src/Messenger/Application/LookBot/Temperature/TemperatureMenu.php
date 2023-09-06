<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Temperature;

enum TemperatureMenu
{

    case Input;

    case Gateway;

    public function getText(): string
    {
        return match ($this) {
            self::Input => 'Ввести температуру вручную',
            self::Gateway => 'Отправить местоположение'
        };
    }
}
