<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Domain\Context\Request;

use Raspberry\Common\Values\Geolocation\GeolocationInterface;
use Raspberry\Messenger\Domain\Context\Request\CallbackData\CallbackDataInterface;
use Raspberry\Messenger\Domain\Handlers\HandlerType;

interface RequestInterface
{
    /**
     * @return CallbackDataInterface
     */
    public function getCallbackData(): CallbackDataInterface;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @return HandlerType
     */
    public function getRequestType(): HandlerType;

    /**
     * @return GeolocationInterface|null
     */
    public function getGeolocation(): ?GeolocationInterface;
}
