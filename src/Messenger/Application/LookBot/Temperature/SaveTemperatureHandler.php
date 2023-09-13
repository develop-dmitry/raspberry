<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot\Temperature;

use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Values\Temperature\Temperature;
use Raspberry\Look\Domain\Look\Services\Picker\Exceptions\FailedSavePropertyException;
use Raspberry\Look\Domain\Look\Services\Picker\PickerRepositoryInterface;
use Raspberry\Look\Infrastructure\Repositories\PickerRepository;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Application\LookBot\Enums\TextAction;
use Raspberry\Messenger\Application\LookBot\Event\EventListHandler;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Message\Message;
use Raspberry\Messenger\Domain\Messenger\MessengerGatewayInterface;

class SaveTemperatureHandler extends AbstractHandler
{

    protected PickerRepositoryInterface $pickerRepository;

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

        $this->pickerRepository = new PickerRepository($this->contextUser->getId()->getValue());

        try {
            $this->saveTemperature($this->contextRequest->getMessage());
            $this->next->handle($context, $messenger);
        } catch (InvalidValueException) {
            $this->contextUser->setMessageHandler(TextAction::SaveTemperature->value);
            $messenger->sendMessage(Message::text('Введена некорректная температура, попробуйте еще раз'));
        } catch (FailedSavePropertyException) {
            $messenger->sendMessage(Message::text('Произошла ошибка, попробуйте позднее'));
        }
    }

    /**
     * @param string $temperature
     * @return void
     * @throws FailedSavePropertyException
     * @throws InvalidValueException
     */
    protected function saveTemperature(string $temperature): void
    {
        $temperature = new Temperature($temperature);
        $this->pickerRepository->setTemperature($temperature->getValue());
    }
}
