<?php

declare(strict_types=1);

namespace App\Catalog\Application;

use App\Catalog\Domain\Catalog\Event\ProductAddedToCatalogEvent;
use App\Catalog\Domain\Catalog\Event\ProductRemovedFromCatalogEvent;
use App\Catalog\Domain\Catalog\Factory\CatalogFactory;
use App\Catalog\Domain\Catalog\ValueObject\CatalogId;
use App\Shared\Application\Event\EventDispatcher;
use App\Shared\Domain\ValueObject\ProductId;
use App\Catalog\Infrastructure\Persistence\Mysql\Repository\CatalogRepository;

/**
 * Class CatalogCommandService
 *
 * @package App\Catalog\Application
 */
class CatalogCommandService {

    /**
     * @var CatalogRepository
     */
    private $catalogRepository;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * CatalogCommandService constructor.
     *
     * @param CatalogRepository $catalogRepository
     * @param EventDispatcher   $eventDispatcher
     */
    public function __construct(CatalogRepository $catalogRepository, EventDispatcher $eventDispatcher) {
        $this->catalogRepository = $catalogRepository;
        $this->eventDispatcher = $eventDispatcher;
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

        // start transaction
        $this->catalogRepository->saveCatalog($catalog);
        $this->eventDispatcher->dispatch(
            new ProductAddedToCatalogEvent($catalogId->getId(), $catalog->getCatalogName()->getName(), $productId),
            ProductAddedToCatalogEvent::NAME);
        // end transaction
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
        $this->eventDispatcher->dispatch(
            new ProductRemovedFromCatalogEvent($catalogId->getId(), $productId),
            ProductRemovedFromCatalogEvent::NAME
        );
    }
}