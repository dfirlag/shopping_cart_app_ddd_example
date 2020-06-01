<?php

declare(strict_types=1);

namespace Product\Infrastructure\Persistence\Mysql\Listener;

use App\Cart\Infrastructure\Persistence\Mysql\Cart;
use App\Product\Application\ProductQueryService;
use App\Product\Infrastructure\Persistence\Mysql\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PreFlush;

class CartListener {

    /**
     * @var ProductQueryService
     */
    private $productQueryService;

    /**
     * CartListener constructor.
     *
     * @param ProductQueryService $productQueryService
     */
    public function __construct(ProductQueryService $productQueryService) {
        $this->productQueryService = $productQueryService;
    }

    /**
     * @PrePersist
     */
    public function prePersistHandler(Cart $cart, LifecycleEventArgs $event) {
        $this->setProductIdsAndTotalAmount($cart, $event->getEntityManager());
    }

    /**
     * @PreUpdate
     */
    public function preUpdateHandler(Cart $cart, LifecycleEventArgs $event) {
        $this->setProductIdsAndTotalAmount($cart, $event->getEntityManager());
    }

    /**
     * @PreFlush
     */
    public function preFlashHandler(Cart $cart, PreFlushEventArgs $event) {
        $this->setProductIdsAndTotalAmount($cart, $event->getEntityManager());
    }

    /**
     * @param Cart          $cart
     * @param EntityManager $entityManager
     */
    private function setProductIdsAndTotalAmount(Cart $cart, EntityManager $entityManager) {
        $products = $entityManager
            ->getRepository(Product::class)
            ->findBy(['id' => $cart->getProductIds()]);

        $total = $this->productQueryService->getTotalAmountFromProducts($products);

        $cart->setTotalPrice($total);
        $cart->setProducts($products);
    }
}