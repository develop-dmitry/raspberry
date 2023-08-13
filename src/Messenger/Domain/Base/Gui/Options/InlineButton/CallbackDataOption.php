<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Gui\Options\InlineButton;

use Illuminate\Database\Eloquent\Casts\Json;
use Raspberry\Messenger\Domain\Base\Gui\Options\OptionInterface;

class CallbackDataOption implements OptionInterface
{
    protected string $action;

    protected array $query;

    public function __construct(string $action, array $query)
    {
        unset($query['action']);

        $this->action = $action;
        $this->query = $query;
    }

    public function getValue(): mixed
    {
        $toJson = array_merge(['action' => $this->action, $this->query]);

        return Json::encode($toJson);
    }
}
