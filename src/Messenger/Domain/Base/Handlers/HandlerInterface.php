<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Base\Handlers;

use Raspberry\Messenger\Domain\Base\Context\ContextInterface;
use Raspberry\Messenger\Domain\Base\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Base\Handlers\Exceptions\FailedAuthorizeException;

interface HandlerInterface
{
    /**
     * @param ContextInterface $context
     * @param GuiInterface $gui
     * @return void
     * @throws FailedAuthorizeException
     */
    public function handle(ContextInterface $context, GuiInterface $gui): void;
}
