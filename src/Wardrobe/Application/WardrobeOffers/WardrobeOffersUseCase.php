<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeOffers;

use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffer;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersRequest;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersResponse;
use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers\WardrobeOffersContainer\WardrobeOffersContainerInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Services\WardrobeOffers\WardrobeOffersServiceInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeRepositoryInterface;

class WardrobeOffersUseCase implements WardrobeOffersInterface
{
    public function __construct(
        protected WardrobeRepositoryInterface $wardrobeRepository,
        protected WardrobeOffersServiceInterface $wardrobeOffersService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(WardrobeOffersRequest $request): WardrobeOffersResponse
    {
        $wardrobe = $this->wardrobeRepository->getWardrobe($request->getUserId());
        $offersContainer = $this->wardrobeOffersService->getOffers(
            $wardrobe,
            $request->getPage(),
            $request->getCount()
        );

        return new WardrobeOffersResponse(
            $this->getOffers($offersContainer),
            $offersContainer->getPage(),
            $offersContainer->getTotal(),
            $offersContainer->getCount()
        );
    }

    /**
     * @param WardrobeOffersContainerInterface $container
     * @return WardrobeOffer[]
     */
    protected function getOffers(WardrobeOffersContainerInterface $container): array
    {
        $offers = [];

        foreach ($container->getClothes() as $clothes) {
            $offers[] = $this->convertClothes($clothes);
        }

        return $offers;
    }

    /**
     * @param ClothesInterface $clothes
     * @return WardrobeOffer
     */
    protected function convertClothes(ClothesInterface $clothes): WardrobeOffer
    {
        return new WardrobeOffer(
            $clothes->getId()->getValue(),
            $clothes->getName()->getValue(),
            $clothes->getSlug()->getValue(),
            $clothes->getPhoto()->getValue()
        );
    }
}
