<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Handlers;

use Raspberry\Common\Values\Id\Id;
use Raspberry\Common\Values\Id\IdInterface;
use Raspberry\Messenger\Domain\Base\Context\ContextInterface;
use Raspberry\Messenger\Domain\Base\Gui\GuiInterface;

class AbstractAuthorizeHandler extends AbstractHandler
{
    protected IdInterface $userId;

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, GuiInterface $gui): void
    {
        parent::handle($context, $gui);

        $this->authorize();
    }

    protected function authorize(): void
    {
        // todo разработать механизм авторизации
        $this->userId = new Id(1);
    }
}
