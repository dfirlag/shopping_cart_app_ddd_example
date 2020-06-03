<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog\Factory;

use App\Catalog\Domain\Catalog\CatalogQuery;
use App\Catalog\Domain\Catalog\Persistence\Repository\CatalogReadModelRepositoryInterface;
use App\Catalog\Domain\Catalog\ValueObject\CatalogId;
use App\Catalog\Domain\Catalog\ValueObject\ProductQuery;
use App\Catalog\Infrastructure\Persistence\Mysql\CatalogReadModel;
use Money\Currency;
use Money\Money;

/**
 * Class CatalogQueryFactory
 *
 * @package App\Catalog\Domain\Catalog\Factory
 */
class CatalogQueryFactory {

    /**
     * @param CatalogId $catalogId
     * @param           $catalogModels
     * @return CatalogQuery
     */
    public static function createFromModel(CatalogId $catalogId, $catalogModels): CatalogQuery
    {
        $catalogQuery = new CatalogQuery($catalogId);
        foreach ($catalogModels as $catalogModel) {
            /** @var CatalogReadModel $catalogModel */
            $catalogQuery->getCatalogProductCollection()->addProduct(new ProductQuery(
                $catalogModel->getProduct()->getId(),
                $catalogModel->getProductName(),
                new Money($catalogModel->getProductPrice(), new Currency($catalogModel->getCurrency()))
            ));
        }

        return $catalogQuery;
    }

    /**
     * @param CatalogId                           $catalogId
     * @param CatalogReadModelRepositoryInterface $catalogReadModelRepository
     * @return CatalogQuery
     */
    public static function createById(
        CatalogId $catalogId, CatalogReadModelRepositoryInterface $catalogReadModelRepository): CatalogQuery
    {
        $cartModels = $catalogReadModelRepository->findBy(['catalog' => $catalogId->getId()]);
        return self::createFromModel($catalogId, $cartModels);
    }

    /**
     * @param CatalogId                           $catalogId
     * @param int                                 $page
     * @param int                                 $itemPerPage
     * @param CatalogReadModelRepositoryInterface $catalogReadModelRepository
     * @return CatalogQuery
     */
    public static function createPaginatedCatalog(
        CatalogId $catalogId,
        int $page,
        int $itemPerPage,
        CatalogReadModelRepositoryInterface $catalogReadModelRepository): CatalogQuery
    {
        $catalogModels = $catalogReadModelRepository->getPaginated(
            $catalogId,
            $page,
            $itemPerPage
        );
        return self::createFromModel($catalogId, $catalogModels);
    }
}