<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Messenger;

enum RunningMode
{

    case Listener;

    case Webhook;
}
