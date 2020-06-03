<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Persistence\Mysql\Listener;

use App\Cart\Infrastructure\Persistence\Mysql\CartReadModel;
use App\Catalog\Infrastructure\Persistence\Mysql\CatalogReadModel;
use App\Product\Application\ProductQueryService;
use App\Product\Infrastructure\Persistence\Mysql\Repository\ProductRepository;
use App\Shared\Domain\ValueObject\ProductId;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CatalogReadModelListener
 *
 * @package App\Product\Infrastructure\Persistence\Mysql\Listener
 */
class CatalogReadModelListener {

    /**
     * @var ProductQueryService
     */
    private $productQueryService;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * CatalogReadModelListener constructor.
     *
     * @param ProductQueryService $productQueryService
     * @param ProductRepository   $productRepository
     */
    public function __construct(ProductQueryService $productQueryService, ProductRepository $productRepository) {
        $this->productQueryService = $productQueryService;
        $this->productRepository = $productRepository;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersistHandler(CatalogReadModel $catalog, LifecycleEventArgs $event) {
        $this->setProductNameAndPrice($catalog, $event->getEntityManager());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdateHandler(CatalogReadModel $catalog, LifecycleEventArgs $event) {
        $this->setProductNameAndPrice($catalog, $event->getEntityManager());
    }

    /**
     * @ORM\PreFlush
     */
    public function preFlashHandler(CatalogReadModel $catalog, PreFlushEventArgs $event) {
        $this->setProductNameAndPrice($catalog, $event->getEntityManager());
    }

    /**
     * @param CartReadModel $catalog
     * @param EntityManager $entityManager
     * @throws \App\Product\Domain\Product\Exception\ProductNotFoundException
     */
    public function setProductNameAndPrice(CatalogReadModel $catalog, EntityManager $entityManager) {
        $productModel = $this->productRepository->find($catalog->getProductId());
        $product = $this->productQueryService->getProduct(new ProductId($catalog->getProductId()));

        $catalog->setProduct($productModel);
        $catalog->setProductName($product->getProductName()->getName());
        $catalog->setProductPrice($product->getProductPrice()->getPrice()->getAmount());
        $catalog->setCurrency($product->getProductPrice()->getPrice()->getCurrency()->getCode());
    }
}