<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog\Factory;

use App\Catalog\Domain\Catalog\Catalog;
use App\Catalog\Domain\Catalog\Persistence\CatalogModelInterface;
use App\Catalog\Domain\Catalog\Persistence\Repository\CatalogRepositoryInterface;
use App\Catalog\Domain\Catalog\ValueObject\CatalogId;
use App\Catalog\Domain\Catalog\ValueObject\CatalogName;
use App\Shared\Domain\ValueObject\ProductCollection;
use App\Catalog\Domain\Catalog\Exception\CatalogNotFoundException;

/**
 * Class CatalogFactory
 *
 * @package App\Catalog\Domain\Catalog\Factory
 */
class CatalogFactory {

    /**
     * @param CatalogModelInterface $catalogModel
     * @return Catalog
     */
    public static function createFromModel(CatalogModelInterface $catalogModel): Catalog
    {
        return new Catalog(
            new CatalogId($catalogModel->getId()),
            new CatalogName($catalogModel->getName()),
            ProductCollection::createFromArray($catalogModel->getProductIds())
        );
    }

    /**
     * @param CatalogId                  $catalogId
     * @param CatalogRepositoryInterface $catalogRepository
     * @return Catalog
     * @throws CatalogNotFoundException
     */
    public static function createById(CatalogId $catalogId, CatalogRepositoryInterface $catalogRepository): Catalog
    {
        $catalogModel = $catalogRepository->find($catalogId->getId());

        if ($catalogModel === null) {
            throw new CatalogNotFoundException();
        }

        return self::createFromModel($catalogModel);
    }
}