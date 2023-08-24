<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Raspberry\Look\Application\DetailLook\DetailLookInterface;
use Raspberry\Look\Application\DetailLook\DetailLookUseCase;
use Raspberry\Look\Application\DetailLookUrl\DetailLookUrlInterface;
use Raspberry\Look\Application\DetailLookUrl\DetailLookUrlUseCase;
use Raspberry\Look\Application\SelectionLook\SelectionLookUseCase;
use Raspberry\Look\Application\SelectionLook\SelectionLookInterface;
use Raspberry\Look\Application\UserStyles\UserStylesInterface;
use Raspberry\Look\Application\UserStyles\UserStylesUseCase;
use Raspberry\Look\Domain\Event\EventRepositoryInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\Look\Services\LookUrlGenerator\LookUrlGeneratorServiceInterface;
use Raspberry\Look\Domain\Look\Services\LookUrlGenerator\LookUrlGeneratorService;
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
        $this->app->bind(SelectionLookInterface::class, SelectionLookUseCase::class);
        $this->app->bind(LookUrlGeneratorServiceInterface::class, LookUrlGeneratorService::class);
        $this->app->bind(DetailLookUrlInterface::class, DetailLookUrlUseCase::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(StyleRepositoryInterface::class, StyleRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserStylesInterface::class, UserStylesUseCase::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
