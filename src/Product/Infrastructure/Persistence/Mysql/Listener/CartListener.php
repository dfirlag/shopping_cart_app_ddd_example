<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Persistence\Mysql\Listener;

use App\Cart\Infrastructure\Persistence\Mysql\Cart;
use App\Product\Application\ProductQueryService;
use App\Product\Infrastructure\Persistence\Mysql\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\PrePersist
     */
    public function prePersistHandler(Cart $cart, LifecycleEventArgs $event) {
        $this->setProductIdsAndTotalAmount($cart, $event->getEntityManager());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdateHandler(Cart $cart, LifecycleEventArgs $event) {
        $this->setProductIdsAndTotalAmount($cart, $event->getEntityManager());
    }

    /**
     * @ORM\PreFlush
     */
    public function preFlashHandler(Cart $cart, PreFlushEventArgs $event) {
        $this->setProductIdsAndTotalAmount($cart, $event->getEntityManager());
    }

    /** @ORM\PostLoad */
    public function postLoadHandler(Cart $cart, LifecycleEventArgs $event)
    {
        $productsIds = [];
        foreach ($cart->getProducts()->getIterator() as $row) {
            $productsIds[] = $row->getId();
        }

        $cart->setProductIds($productsIds);
        $cart->setTotalPrice($this->productQueryService->getTotalAmountFromProducts($cart->getProducts()->toArray()));
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