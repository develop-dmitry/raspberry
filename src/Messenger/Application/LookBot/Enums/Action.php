<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Enums;

enum Action: string
{

    case EventList = 'look_event_list';

    case EventChoose = 'look_event_choose';

    case StylesUser = 'styles_user';
}
