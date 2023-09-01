<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Raspberry\Wardrobe\Application\AddClothes\AddClothesInterface;
use Raspberry\Wardrobe\Application\AddClothes\AddClothesUseCase;
use Raspberry\Wardrobe\Application\RemoveClothes\RemoveClothesInterface;
use Raspberry\Wardrobe\Application\RemoveClothes\RemoveClothesUseCase;
use Raspberry\Wardrobe\Application\UrlGenerator\UrlGeneratorInterface;
use Raspberry\Wardrobe\Application\UrlGenerator\UrlGeneratorUseCase;
use Raspberry\Wardrobe\Application\WardrobeList\WardrobeListInterface;
use Raspberry\Wardrobe\Application\WardrobeList\WardrobeListUseCase;
use Raspberry\Wardrobe\Application\WardrobeOffers\WardrobeOffersInterface;
use Raspberry\Wardrobe\Application\WardrobeOffers\WardrobeOffersUseCase;
use Raspberry\Wardrobe\Domain\Clothes\ClothesRepositoryInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Services\UrlGeneratorService\UrlGeneratorService;
use Raspberry\Wardrobe\Domain\Wardrobe\Services\UrlGeneratorService\UrlGeneratorServiceInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers\WardrobeOffersService;
use Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers\WardrobeOffersServiceInterface;
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
        $this->app->bind(RemoveClothesInterface::class, RemoveClothesUseCase::class);
        $this->app->bind(WardrobeOffersServiceInterface::class, WardrobeOffersService::class);
        $this->app->bind(WardrobeOffersInterface::class, WardrobeOffersUseCase::class);
        $this->app->bind(WardrobeListInterface::class, WardrobeListUseCase::class);
        $this->app->bind(UrlGeneratorServiceInterface::class, UrlGeneratorService::class);
        $this->app->bind(UrlGeneratorInterface::class, UrlGeneratorUseCase::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
