<?php

namespace Raspberry\Look\Application\HowFit\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class HowFitRequest extends DataTransferObject
{

    public int $userId;

    public int $lookId;
}
