<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Raspberry\Messenger\Domain\Context\User\UserRepositoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineButtonOptionFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\InlineKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyButtonFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyButtonOptionFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Gui\Factory\ReplyKeyboardOptionFactoryInterface;
use Raspberry\Messenger\Infrastructure\Gateway\TelegramMessengerGateway;
use Raspberry\Messenger\Infrastructure\Gui\Base\Factory\InlineButtonFactory;
use Raspberry\Messenger\Infrastructure\Gui\Base\Factory\InlineButtonOptionFactory;
use Raspberry\Messenger\Infrastructure\Gui\Base\Factory\InlineKeyboardFactory;
use Raspberry\Messenger\Infrastructure\Gui\Base\Factory\ReplyButtonFactory;
use Raspberry\Messenger\Infrastructure\Gui\Base\Factory\ReplyButtonOptionFactory;
use Raspberry\Messenger\Infrastructure\Gui\Base\Factory\ReplyKeyboardFactory;
use Raspberry\Messenger\Infrastructure\Gui\Base\Factory\ReplyKeyboardOptionFactory;
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

        $this->app->bind(InlineButtonOptionFactoryInterface::class, InlineButtonOptionFactory::class);
        $this->app->bind(ReplyKeyboardOptionFactoryInterface::class, ReplyKeyboardOptionFactory::class);
        $this->app->bind(ReplyButtonOptionFactoryInterface::class, ReplyButtonOptionFactory::class);

        $this->app
            ->when(TelegramMessengerGateway::class)
            ->needs(UserRepositoryInterface::class)
            ->give(TelegramUserRepository::class);

        $this->app
            ->when(TelegramMessengerGateway::class)
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
