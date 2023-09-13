<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application;

use Raspberry\Core\Pagination\PaginationInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\Keyboards\InlineKeyboard\InlineKeyboardInterface;
use Raspberry\Messenger\Domain\Gui\Options\ButtonOptions\InlineButton\CallbackDataOption;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

abstract class AbstractPaginationHandler extends AbstractHandler
{

    protected PaginationInterface $pagination;

    /**
     * @return bool
     */
    protected function canSwitchPage(): bool
    {
        return $this->pagination->hasPrev() || $this->pagination->hasNext();
    }

    /**
     * @return InlineKeyboardInterface
     * @throws UnknownProperties
     */
    protected function makePaginationKeyboard(): InlineKeyboardInterface
    {
        $keyboard = $this->inlineKeyboardFactory->make();

        foreach ($this->pagination->getItems() as $item) {
            $keyboard->addRow($this->makeItemButton($item));
        }

        if ($this->canSwitchPage()) {
            $keyboard->addRow(...$this->makePaginationRow());
        }

        return $keyboard;
    }

    /**
     * @param mixed $item
     * @return InlineButtonInterface
     * @throws UnknownProperties
     */
    abstract protected function makeItemButton(mixed $item): InlineButtonInterface;

    /**
     * @return InlineButtonInterface[]
     */
    protected function makePaginationRow(): array
    {
        $row = [];

        if ($this->pagination->hasPrev()) {
            $row[] = $this->makePaginationButton('Назад', $this->action(), $this->prevPage());
        }

        if ($this->pagination->hasNext()) {
            $row[] = $this->makePaginationButton('Вперед', $this->action(), $this->nextPage());
        }

        return $row;
    }

    /**
     * @param string $text
     * @param string $action
     * @param int $page
     * @return InlineButtonInterface
     */
    protected function makePaginationButton(string $text, string $action, int $page): InlineButtonInterface
    {
        return $this->inlineButtonFactory
            ->setText($text)
            ->setCallbackData(new CallbackDataOption($action, ['page' => $page, 'pagination' => true]))
            ->make();
    }

    protected function page(): int
    {
        return $this->contextRequest->getCallbackData()->get('page', 1);
    }

    /**
     * @return int
     */
    protected function nextPage(): int
    {
        return $this->page() + 1;
    }

    /**
     * @return int
     */
    protected function prevPage(): int
    {
        return $this->page() - 1;
    }

    /**
     * @return string
     */
    abstract protected function action(): string;
}
