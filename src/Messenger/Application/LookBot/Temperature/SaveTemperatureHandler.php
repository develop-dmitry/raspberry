<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Temperature;

use Raspberry\Core\Values\Exceptions\InvalidValueException;
use Raspberry\Core\Values\Temperature\Temperature;
use Raspberry\Look\Domain\Look\Services\SelectionLook\Exceptions\FailedSavePropertyException;
use Raspberry\Look\Domain\Look\Services\SelectionLook\SelectionLookRepositoryInterface;
use Raspberry\Look\Infrastructure\Repositories\SelectionLookRepository;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\LookBot\Enums\TextAction;
use Raspberry\Messenger\Application\LookBot\Event\EventListHandler;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Handlers\HandlerInterface;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;

class SaveTemperatureHandler extends AbstractHandler
{

    protected SelectionLookRepositoryInterface $selectionLookRepository;

    /**
     * @param EventListHandler $next
     * @param GuiFactoryInterface $guiFactory
     */
    public function __construct(
        protected EventListHandler $next,
        GuiFactoryInterface $guiFactory
    ) {
        parent::__construct($guiFactory);
    }

    public function isNeedAuthorize(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, MessengerGatewayInterface $messenger): void
    {
        parent::handle($context, $messenger);

        $this->selectionLookRepository = new SelectionLookRepository($this->contextUser->getId()->getValue());

        try {
            $temperature = new Temperature($this->contextRequest->getMessage());
            $this->selectionLookRepository->setTemperature($temperature->getValue());

            $this->next->handle($context, $messenger);
        } catch (InvalidValueException) {
            $messenger->sendMessage(Message::text('Введена некорректная температура, попробуйте еще раз'));
            $this->contextUser->setMessageHandler(TextAction::SaveTemperature->value);
        } catch (FailedSavePropertyException) {
            $messenger->sendMessage(Message::text('Произошла ошбика, попробуйте позднее'));
        }
    }
}
