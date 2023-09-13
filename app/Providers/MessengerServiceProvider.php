<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Raspberry\Messenger\Domain\Context\User\UserRepositoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactory\GuiFactory;
use Raspberry\Messenger\Domain\Gui\Factory\GuiFactory\GuiFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonFactory\InlineButtonFactory;
use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonFactory\InlineButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineKeyboardFactory\InlineKeyboardFactory;
use Raspberry\Messenger\Domain\Gui\Factory\InlineKeyboardFactory\InlineKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyButtonFactory\ReplyButtonFactory;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyButtonFactory\ReplyButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyKeyboardFactory\ReplyKeyboardFactory;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyKeyboardFactory\ReplyKeyboardFactoryInterface;
use Raspberry\Messenger\Infrastructure\Messenger\Telegram\TelegramMessenger;
use Raspberry\Messenger\Infrastructure\Repositories\TelegramUserRepository;
use SergiX44\Nutgram\Nutgram;

class MessengerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(InlineButtonFactoryInterface::class, InlineButtonFactory::class);
        $this->app->bind(ReplyButtonFactoryInterface::class, ReplyButtonFactory::class);
        $this->app->bind(ReplyKeyboardFactoryInterface::class, ReplyKeyboardFactory::class);
        $this->app->bind(InlineKeyboardFactoryInterface::class, InlineKeyboardFactory::class);
        $this->app->bind(GuiFactoryInterface::class, GuiFactory::class);

        $this->app->when(TelegramMessenger::class)
            ->needs(UserRepositoryInterface::class)
            ->give(TelegramUserRepository::class);

        $this->app->when(TelegramMessenger::class)
            ->needs(Nutgram::class)
            ->give(static fn() => new Nutgram(config('bot.telegram_token')));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
