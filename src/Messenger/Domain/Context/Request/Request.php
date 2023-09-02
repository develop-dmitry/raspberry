<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context\Request;

use Raspberry\Common\Values\Geolocation\GeolocationInterface;
use Raspberry\Messenger\Domain\Context\Request\CallbackData\CallbackDataInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerType;

class Request implements RequestInterface
{
    /**
     * @param string $message
     * @param CallbackDataInterface $callbackData
     * @param HandlerType $requestType
     * @param GeolocationInterface|null $geolocation
     */
    public function __construct(
        protected string $message,
        protected CallbackDataInterface $callbackData,
        protected HandlerType $requestType,
        protected ?GeolocationInterface $geolocation
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getCallbackData(): CallbackDataInterface
    {
        return $this->callbackData;
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function getRequestType(): HandlerType
    {
        return $this->requestType;
    }

    /**
     * @inheritDoc
     */
    public function getGeolocation(): ?GeolocationInterface
    {
        return $this->geolocation;
    }
}
