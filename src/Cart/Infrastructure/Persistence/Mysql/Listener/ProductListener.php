<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Persistence\Mysql\Listener;

use App\Cart\Application\CartReadModelCommandService;
use App\Product\Infrastructure\Persistence\Mysql\Product;
use App\Shared\Domain\ValueObject\ProductId;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductListener
 *
 * @package App\Cart\Infrastructure\Persistence\Mysql\Listener
 */
class ProductListener {
    /**
     * @var CartReadModelCommandService
     */
    private $cartReadModelCommandService;

    /**
     * CartListener constructor.
     *
     * @param CartReadModelCommandService $cartReadModelCommandService
     */
    public function __construct(CartReadModelCommandService $cartReadModelCommandService) {
        $this->cartReadModelCommandService = $cartReadModelCommandService;
    }

    /**
     * @ORM\PostPersist
     */
    public function prePersistHandler(Product $product, LifecycleEventArgs $event) {
        $this->cartReadModelCommandService->refreshCartReadModel(new ProductId($product->getId()));
    }

    /**
     * @ORM\PostUpdate
     */
    public function preUpdateHandler(Product $product, LifecycleEventArgs $event) {
        $this->cartReadModelCommandService->refreshCartReadModel(new ProductId($product->getId()));
    }
}