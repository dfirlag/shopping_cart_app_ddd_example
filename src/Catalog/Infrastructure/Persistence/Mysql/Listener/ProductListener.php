<?php

declare(strict_types=1);

namespace App\Catalog\Infrastructure\Persistence\Mysql\Listener;

use App\Catalog\Application\CatalogReadModelCommandService;
use App\Product\Infrastructure\Persistence\Mysql\Product;
use App\Shared\Domain\ValueObject\ProductId;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductListener
 *
 * @package App\Catalog\Infrastructure\Persistence\Mysql\Listener
 */
class ProductListener {

    /**
     * @var CatalogReadModelCommandService
     */
    private $catalogReadModelCommandService;

    /**
     * CartListener constructor.
     *
     * @param CatalogReadModelCommandService $catalogReadModelCommandService
     */
    public function __construct(CatalogReadModelCommandService $catalogReadModelCommandService) {
        $this->catalogReadModelCommandService = $catalogReadModelCommandService;
    }

    /**
     * @ORM\PostPersist
     */
    public function prePersistHandler(Product $product, LifecycleEventArgs $event) {
        $this->catalogReadModelCommandService->refreshCartReadModel(new ProductId($product->getId()));
    }

    /**
     * @ORM\PostUpdate
     */
    public function preUpdateHandler(Product $product, LifecycleEventArgs $event) {
        $this->catalogReadModelCommandService->refreshCartReadModel(new ProductId($product->getId()));
    }
}