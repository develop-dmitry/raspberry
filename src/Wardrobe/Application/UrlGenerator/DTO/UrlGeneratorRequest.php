<?php

namespace Raspberry\Wardrobe\Application\UrlGenerator\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class UrlGeneratorRequest extends DataTransferObject
{

    public array $query;
}
