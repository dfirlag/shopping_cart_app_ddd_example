<?php

declare(strict_types=1);

namespace App\Catalog\Application;

use App\Catalog\Domain\Catalog\ValueObject\CatalogId;
use App\Catalog\Domain\Catalog\ValueObject\CatalogName;
use App\Catalog\Infrastructure\Persistence\Mysql\Repository\CatalogReadModelRepository;
use App\Shared\Domain\ValueObject\ProductId;

/**
 * Class CatalogReadModelCommandService
 *
 * @package App\Catalog\Application
 */
class CatalogReadModelCommandService {

    /**
     * @param CatalogReadModelRepository
     */
    private $catalogReadModelRepository;

    /**
     * CatalogReadModelCommandService constructor.
     *
     * @param CatalogReadModelRepository $catalogReadModelRepository
     */
    public function __construct(CatalogReadModelRepository $catalogReadModelRepository) {
        $this->catalogReadModelRepository = $catalogReadModelRepository;
    }

    /**
     * @param CatalogName $catalogName
     * @param CatalogId   $catalogId
     * @param ProductId   $productId
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createCatalogReadModel(CatalogName $catalogName, CatalogId $catalogId, ProductId $productId) {
        $this->catalogReadModelRepository->createCatalogReadModel($catalogName, $catalogId, $productId);
    }

    /**
     * @param ProductId $productId
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function refreshCartReadModel(ProductId $productId) {
        $this->catalogReadModelRepository->refreshCatalogReadModels($productId);
    }

    /**
     * @param CatalogId $catalogId
     * @param ProductId $productId
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeCatalogReadModel(CatalogId $catalogId, ProductId $productId) {
        $this->catalogReadModelRepository->removeCatalogReadModel($catalogId, $productId);
    }
}