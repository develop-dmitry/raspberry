<?php

declare(strict_types=1);

namespace Raspberry\Wardrobe\Application\WardrobeOffers;

use Raspberry\Core\Pagination\PaginationInterface;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\ClothesData;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersRequest;
use Raspberry\Wardrobe\Application\WardrobeOffers\DTO\WardrobeOffersResponse;
use Raspberry\Wardrobe\Domain\Clothes\ClothesInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\Exceptions\UserDoesNotExistsException;
use Raspberry\Wardrobe\Domain\Wardrobe\Services\Offers\OffersServiceInterface;
use Raspberry\Wardrobe\Domain\Wardrobe\WardrobeRepositoryInterface;

class WardrobeOffersUseCase implements WardrobeOffersInterface
{

    /**
     * @param WardrobeRepositoryInterface $wardrobeRepository
     * @param OffersServiceInterface $offersService
     */
    public function __construct(
        protected WardrobeRepositoryInterface $wardrobeRepository,
        protected OffersServiceInterface $offersService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(WardrobeOffersRequest $request): WardrobeOffersResponse
    {
        $offersPagination = $this->getWardrobeOffers($request->userId, $request->page, $request->count);

        $items = $offersPagination->getItems();
        $items = array_map(static fn (ClothesInterface $clothes) => ClothesData::fromDomain($clothes), $items);

        return new WardrobeOffersResponse(
            items: $items,
            page: $offersPagination->getPage(),
            total: $offersPagination->getTotal(),
            count: $offersPagination->getPerPage()
        );
    }

    /**
     * @param int $userId
     * @param int $page
     * @param int $count
     * @return PaginationInterface
     * @throws UserDoesNotExistsException
     */
    public function getWardrobeOffers(int $userId, int $page, int $count): PaginationInterface
    {
        $wardrobe = $this->wardrobeRepository->getWardrobe($userId);

        return $this->offersService->getOffers($wardrobe, $page, $count);
    }
}
