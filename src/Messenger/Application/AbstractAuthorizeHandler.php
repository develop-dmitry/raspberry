<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application;

use Raspberry\Authorization\Application\MessengerAuthorization\DTO\MessengerAuthorizationRequest;
use Raspberry\Authorization\Application\MessengerAuthorization\MessengerAuthorizationInterface;
use Raspberry\Authorization\Domain\User\Exceptions\UserNotFoundException;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Handlers\Exceptions\FailedAuthorizeException;

class AbstractAuthorizeHandler extends AbstractHandler
{
    protected int $userId;

    public function __construct(
        protected MessengerAuthorizationInterface $messengerAuthorization
    ) {
    }

    /**
     * @inheritDoc
     */
    public function handle(ContextInterface $context, GuiInterface $gui): void
    {
        parent::handle($context, $gui);

        $this->authorize();
    }

    /**
     * @return void
     * @throws FailedAuthorizeException
     */
    protected function authorize(): void
    {
        try {
            $authRequest = new MessengerAuthorizationRequest($this->contextUser->getMessengerId());
            $authResponse = $this->messengerAuthorization->execute($authRequest);

            $this->userId = $authResponse->getUserId();
        } catch (UserNotFoundException $exception) {
            throw new FailedAuthorizeException($exception->getMessage());
        }
    }
}
