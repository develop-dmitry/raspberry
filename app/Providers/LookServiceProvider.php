<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Raspberry\Look\Application\DetailLook\DetailLookInterface;
use Raspberry\Look\Application\DetailLook\DetailLookUseCase;
use Raspberry\Look\Application\DetailLookUrl\DetailLookUrlInterface;
use Raspberry\Look\Application\DetailLookUrl\DetailLookUrlUseCase;
use Raspberry\Look\Application\SelectionLook\SelectionLookUseCase;
use Raspberry\Look\Application\SelectionLook\SelectionLookInterface;
use Raspberry\Look\Domain\Look\LookRepositoryInterface;
use Raspberry\Look\Domain\Look\Services\LookUrlGenerator\LookUrlGeneratorServiceInterface;
use Raspberry\Look\Domain\Look\Services\LookUrlGenerator\LookUrlGeneratorService;
use Raspberry\Look\Infrastructure\Repositories\LookRepository;

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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
