<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Enums;

enum WardrobeMenu
{

    case ShowWardrobe;

    case WardrobeOffers;

    case Back;

    public function getText(): string
    {
        return match ($this) {
            self::ShowWardrobe => 'Посмотреть гардероб',
            self::WardrobeOffers => 'Обновить гардероб',
            self::Back => 'Назад'
        };

    }
}
