<?php

declare(strict_types=1);

namespace Raspberry\Messenger\Application;

use Raspberry\Common\Pagination\PaginationInterface;
use Raspberry\Messenger\Domain\Gui\Buttons\InlineButton\InlineButtonInterface;
use Raspberry\Messenger\Domain\Gui\Options\InlineButton\CallbackDataOption;

abstract class AbstractPaginationHandler extends AbstractHandler
{

    protected PaginationInterface $pagination;

    protected function canSwitchPage(): bool
    {
        return $this->pagination->hasPrev() || $this->pagination->hasNext();
    }

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
            ->setCallbackData(new CallbackDataOption($action, ['page' => $page]))
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
