<?php

namespace Raspberry\Core\Enums;

enum CompareResult: int
{

    case Equal = 0;

    case Less = -1;

    case More = 1;
}
