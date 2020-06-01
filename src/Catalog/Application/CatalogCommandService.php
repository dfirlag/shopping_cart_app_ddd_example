<?php

declare(strict_types=1);

namespace App\Catalog\Application;

use App\Catalog\Domain\Catalog\Factory\CatalogFactory;
use App\Catalog\Domain\Catalog\ValueObject\CatalogId;
use App\Catalog\Domain\Catalog\ValueObject\ProductId;
use App\Catalog\Infrastructure\Persistence\Mysql\Repository\CatalogRepository;

class CatalogCommandService {

    /**
     * @var CatalogRepository
     */
    private $catalogRepository;

    /**
     * CatalogCommandService constructor.
     *
     * @param CatalogRepository $catalogRepository
     */
    public function __construct(CatalogRepository $catalogRepository) {
        $this->catalogRepository = $catalogRepository;
    }

    /**
     * @param CatalogId $catalogId
     * @param ProductId $productId
     * @throws \App\Catalog\Domain\Catalog\Exception\CatalogNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addProductToCatalog(CatalogId $catalogId, ProductId $productId) {
        $catalog = CatalogFactory::createById($catalogId, $this->catalogRepository);

        $catalog->getProductCollection()->addProductId($productId);

        $this->catalogRepository->saveCatalog($catalog);
    }

    /**
     * @param CatalogId $catalogId
     * @param ProductId $productId
     * @throws \App\Catalog\Domain\Catalog\Exception\CatalogNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeProductFromCatalog(CatalogId $catalogId, ProductId $productId) {
        $catalog = CatalogFactory::createById($catalogId, $this->catalogRepository);

        $catalog->getProductCollection()->removeProductId($productId);

        $this->catalogRepository->saveCatalog($catalog);
    }
}