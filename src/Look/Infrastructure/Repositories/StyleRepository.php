<?php

declare(strict_types=1);

namespace Raspberry\Look\Infrastructure\Repositories;

use App\Models\Style as StyleModel;
use Psr\Log\LoggerInterface;
use Raspberry\Common\Values\Exceptions\InvalidValueException;
use Raspberry\Common\Values\Id\Id;
use Raspberry\Common\Values\Name\Name;
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
        $styles = [];
        $models = StyleModel::whereIn('id', $ids)->get();

        foreach ($models as $model) {
            try {
                $styles[] = $this->makeStyle($model);
            } catch (InvalidValueException $exception) {
                $this->logger->error('Invalid style data in database', ['exception' => $exception->getMessage()]);
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
