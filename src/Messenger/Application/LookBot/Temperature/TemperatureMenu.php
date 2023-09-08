<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Temperature;

enum TemperatureMenu
{

    case Accept;

    case Input;

    case Gateway;

    public function getText(): string
    {
        return match ($this) {
            self::Accept => 'Подтвердить температуру',
            self::Input => 'Ввести температуру вручную',
            self::Gateway => 'Отправить местоположение'
        };
    }
}
