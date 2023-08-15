<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot;

enum MenuEnum
{

    case SelectionLook;

    public function getText(): string
    {
        switch ($this) {
            case self::SelectionLook:
                return 'Подобрать образ';
            default:
                return 'Без названия';
        }
    }
}
