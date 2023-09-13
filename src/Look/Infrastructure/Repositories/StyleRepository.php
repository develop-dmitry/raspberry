<?php

declare(strict_types=1);

namespace Raspberry\Look\Infrastructure\Repositories;

use App\Models\Style as StyleModel;
use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;
use Raspberry\Core\Exceptions\InvalidValueException;
use Raspberry\Core\Pagination\Pagination;
use Raspberry\Core\Pagination\PaginationInterface;
use Raspberry\Core\Values\Id\Id;
use Raspberry\Core\Values\Name\Name;
use Raspberry\Look\Domain\Style\Exceptions\StyleNotFoundException;
use Raspberry\Look\Domain\Style\Style;
use Raspberry\Look\Domain\Style\StyleInterface;
use Raspberry\Look\Domain\Style\StyleRepositoryInterface;

class StyleRepository implements StyleRepositoryInterface
{

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        protected LoggerInterface $logger
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getCollection(array $ids): array
    {
        return $this->makeStyles(StyleModel::whereIn('id', $ids)->get());
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): StyleInterface
    {
        $model = StyleModel::find($id);

        if (!$model) {
            throw new StyleNotFoundException();
        }

        return $this->makeStyle($model);
    }

    /**
     * @inheritDoc
     */
    public function paginate(int $page, int $perPage): PaginationInterface
    {
        $pagination = StyleModel::paginate($perPage, page: $page);

        return new Pagination(
            $this->makeStyles($pagination->getCollection()),
            $pagination->lastPage(),
            $pagination->currentPage(),
            $pagination->perPage()
        );
    }

    /**
     * @param Collection $models
     * @return StyleInterface[]
     */
    protected function makeStyles(Collection $models): array
    {
        $styles = [];

        foreach ($models as $model) {
            try {
                $styles[] = $this->makeStyle($model);
            } catch (InvalidValueException $exception) {
                $this->logger->error('Invalid data in database', ['exception' => $exception->getMessage()]);
            }
        }

        return $styles;
    }

    /**
     * @param StyleModel $style
     * @return StyleInterface
     * @throws InvalidValueException
     */
    protected function makeStyle(StyleModel $style): StyleInterface
    {
        return new Style(
            new Id($style->id),
            new Name($style->name)
        );
    }
}
