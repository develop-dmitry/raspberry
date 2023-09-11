<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Raspberry\Look\Application\DetailLook\DetailLookInterface;
use Raspberry\Look\Application\DetailLook\DetailLookUseCase;
use Raspberry\Look\Application\LookUrl\LookUrlInterface;
use Raspberry\Look\Application\LookUrl\LookUrlUseCase;
use Raspberry\Look\Application\PickerScore\PickerScoreInterface;
use Raspberry\Look\Application\PickerScore\PickerScoreUseCase;
use Raspberry\Look\Application\Picker\PickerUseCase;
use Raspberry\Look\Application\Picker\PickerInterface;
use Raspberry\Look\Application\StylesUser\StylesUserInterface;
use Raspberry\Look\Application\StylesUser\StylesUserUseCase;
use Raspberry\Look\Domain\Event\EventRepositoryInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\Look\Services\UrlGenerator\UrlGeneratorServiceInterface;
use Raspberry\Look\Domain\Look\Services\UrlGenerator\UrlGeneratorService;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;
use Raspberry\Look\Domain\User\UserRepositoryInterface;
use Raspberry\Look\Infrastructure\Repositories\EventRepository;
use Raspberry\Look\Infrastructure\Repositories\LookRepository;
use Raspberry\Look\Infrastructure\Repositories\StyleRepository;
use Raspberry\Look\Infrastructure\Repositories\UserRepository;

class LookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(LookRepositoryInterface::class, LookRepository::class);
        $this->app->bind(DetailLookInterface::class, DetailLookUseCase::class);
        $this->app->bind(PickerInterface::class, PickerUseCase::class);
        $this->app->bind(UrlGeneratorServiceInterface::class, UrlGeneratorService::class);
        $this->app->bind(LookUrlInterface::class, LookUrlUseCase::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(StyleRepositoryInterface::class, StyleRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(StylesUserInterface::class, StylesUserUseCase::class);
        $this->app->bind(PickerScoreInterface::class, PickerScoreUseCase::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
