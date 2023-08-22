<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Handlers;

use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Handlers\Arguments\HandlerArgumentsInterface;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;

interface HandlerInterface
{
    /**
     * @param ContextInterface $context
     * @param GuiInterface $gui
     * @param HandlerArgumentsInterface|null $args
     * @return void
     * @throws FailedAuthorizeException
     */
    public function handle(ContextInterface $context, GuiInterface $gui, ?HandlerArgumentsInterface $args = null): void;
}
