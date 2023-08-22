<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application\LookBot;

use Exception;
use Psr\Log\LoggerInterface;
use Raspberry\Look\Application\DetailLookUrl\DetailLookUrlInterface;
use Raspberry\Look\Application\DetailLookUrl\DTO\DetailLookUrlRequest;
use Raspberry\Look\Application\SelectionLook\DTO\LookItem;
use Raspberry\Look\Application\SelectionLook\DTO\SelectionLookRequest;
use Raspberry\Look\Application\SelectionLook\SelectionLookInterface;
use Raspberry\Look\Domain\Look\Exceptions\LookNotFoundException;
use Raspberry\Look\Domain\Look\Services\LookUrlGenerator\Exceptions\FailedUrlGenerateException;
use Raspberry\Messenger\Application\AbstractHandler;
use Raspberry\Messenger\Domain\Context\ContextInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\GuiInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Options\InlineButton\WebAppOption;

class SelectionLookHandler extends AbstractHandler
{

    public function __construct(
        protected SelectionLookInterface $selectionLook,
        protected DetailLookUrlInterface $detailLookUrl,
        protected LoggerInterface $logger
    ) {
    }

    public function handle(ContextInterface $context, GuiInterface $gui): void
    {
        parent::handle($context, $gui);

        /*$selectionRequest = new SelectionLookRequest(-30, 30);
        $selectionResponse = $this->selectionLook->execute($selectionRequest);
        $looks = $selectionResponse->getLooks();*/
        $looks = [];

        if (empty($looks)) {
            $gui->sendMessage('К сожалению, мы не смогли подобрать для вас образ :(');
        } else {
            $gui
                ->sendMessage('Для вас подобраны следующие образы')
                ->sendInlineKeyboard($this->makeKeyboard($looks));
        }
    }

    /**
     * @param LookItem[] $looks
     * @return InlineKeyboardInterface
     */
    protected function makeKeyboard(array $looks): InlineKeyboardInterface
    {
        $keyboard = $this->inlineKeyboardFactory->make();

        foreach (array_slice($looks, 0, 5) as $look) {
            try {
                $keyboard->addRow($this->makeButton($look));
            } catch (Exception $exception) {
                $this->logger->error('Failed to make look button', [
                    'exception' => $exception->getMessage(),
                    'look' => $look->toArray()
                ]);

                continue;
            }
        }

        return $keyboard;
    }

    /**
     * @param LookItem $item
     * @return InlineButtonInterface
     * @throws FailedUrlGenerateException
     * @throws LookNotFoundException
     */
    protected function makeButton(LookItem $item): InlineButtonInterface
    {
        return $this->inlineButtonFactory
            ->setText($item->getName())
            ->setWebApp(new WebAppOption($this->makeUrl($item)))
            ->make();
    }

    /**
     * @throws FailedUrlGenerateException
     * @throws LookNotFoundException
     */
    protected function makeUrl(LookItem $item): string
    {
        $request = new DetailLookUrlRequest($item->getId());

        return $this->detailLookUrl->execute($request)->getUrl();
    }
}
