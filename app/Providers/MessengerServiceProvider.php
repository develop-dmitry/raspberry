<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Raspberry\Messenger\Domain\Base\Context\User\UserRepositoryInterface;
use Raspberry\Messenger\Domain\Base\Gui\Buttons\InlineButton\Factory\InlineButtonFactory;
use Raspberry\Messenger\Domain\Base\Gui\Buttons\InlineButton\Factory\InlineButtonFactoryInterface;
use Raspberry\Messenger\Domain\Base\Gui\Buttons\ReplyButton\Factory\ReplyButtonFactory;
use Raspberry\Messenger\Domain\Base\Gui\Buttons\ReplyButton\Factory\ReplyButtonFactoryInterface;
use Raspberry\Messenger\Domain\Base\Gui\Keyboards\InlineKeyboard\Factory\InlineKeyboardFactory;
use Raspberry\Messenger\Domain\Base\Gui\Keyboards\InlineKeyboard\Factory\InlineKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Base\Gui\Keyboards\ReplyKeyboard\Factory\ReplyKeyboardFactory;
use Raspberry\Messenger\Domain\Base\Gui\Keyboards\ReplyKeyboard\Factory\ReplyKeyboardFactoryInterface;
use Raspberry\Messenger\Domain\Base\Gui\Options\InlineButton\Factory\InlineButtonOptionFactory;
use Raspberry\Messenger\Domain\Base\Gui\Options\InlineButton\Factory\InlineButtonOptionFactoryInterface;
use Raspberry\Messenger\Domain\Base\Gui\Options\ReplyButton\Factory\ReplyButtonOptionFactory;
use Raspberry\Messenger\Domain\Base\Gui\Options\ReplyButton\Factory\ReplyButtonOptionFactoryInterface;
use Raspberry\Messenger\Domain\Base\Gui\Options\ReplyKeyboard\Factory\ReplyKeyboardOptionFactory;
use Raspberry\Messenger\Domain\Base\Gui\Options\ReplyKeyboard\Factory\ReplyKeyboardOptionFactoryInterface;
use Raspberry\Messenger\Infrastructure\Gateway\TelegramMessengerGateway;
use Raspberry\Messenger\Infrastructure\Repositories\RedisTelegramUserRepository;
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
            ->give(RedisTelegramUserRepository::class);

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
