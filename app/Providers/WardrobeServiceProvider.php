<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Raspberry\Wardrobe\Application\AddClothes\AddClothesInterface;
use Raspberry\Wardrobe\Application\AddClothes\AddClothesUseCase;
use Raspberry\Wardrobe\Domain\Clothes\ClothesRepositoryInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeRepositoryInterface;
use Raspberry\Wardrobe\Infrastructure\Repositories\ClothesRepository;
use Raspberry\Wardrobe\Infrastructure\Repositories\WardrobeRepository;

class WardrobeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(WardrobeRepositoryInterface::class, WardrobeRepository::class);
        $this->app->bind(ClothesRepositoryInterface::class, ClothesRepository::class);
        $this->app->bind(AddClothesInterface::class, AddClothesUseCase::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
