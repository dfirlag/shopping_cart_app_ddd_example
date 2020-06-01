<?php

namespace App\Catalog\Domain\Catalog\Factory;

use App\Catalog\Domain\Catalog\Catalog;
use App\Catalog\Domain\Catalog\Persistence\CatalogModelInterface;
use App\Catalog\Domain\Catalog\Persistence\Repository\CatalogRepositoryInterface;
use App\Catalog\Domain\Catalog\ValueObject\CatalogId;
use App\Catalog\Domain\Catalog\ValueObject\CatalogName;
use App\Catalog\Domain\Catalog\ValueObject\ProductCollection;
use Money\Currency;
use Money\Money;
use App\Catalog\Domain\Catalog\Exception\CatalogNotFoundException;

class CatalogFactory {

    public static function createFromModel(CatalogModelInterface $catalogModel): Catalog
    {
        return new Catalog(
            new CatalogId($catalogModel->getId()),
            new CatalogName($catalogModel->getName()),
            ProductCollection::createFromArray($catalogModel->getProductIds())
        );
    }

    public static function createById(CatalogId $catalogId, CatalogRepositoryInterface $catalogRepository): Catalog
    {
        $catalogModel = $catalogRepository->find($catalogId->getId());

        if ($catalogModel === null) {
            throw new CatalogNotFoundException();
        }

        return self::createFromModel($catalogModel);
    }
}