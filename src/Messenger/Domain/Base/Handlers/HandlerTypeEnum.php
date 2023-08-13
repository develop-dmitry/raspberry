<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Handlers;

enum HandlerTypeEnum: string
{

    case Message = 'message';

    case CallbackQuery = 'callback_query';

    case Text = 'text';

    case Command = 'command';
}
