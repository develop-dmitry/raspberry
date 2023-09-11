<?php

namespace Raspberry\Look\Application\PickerScore\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class PickerScoreRequest extends DataTransferObject
{

    public int $userId;

    public int $lookId;
}
