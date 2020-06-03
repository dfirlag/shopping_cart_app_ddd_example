<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Persistence\Mysql\Listener;

use App\Cart\Infrastructure\Persistence\Mysql\CartReadModel;
use App\Product\Application\ProductQueryService;
use App\Shared\Domain\ValueObject\ProductId;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CartReadModelListener
 *
 * @package App\Product\Infrastructure\Persistence\Mysql\Listener
 */
class CartReadModelListener {

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
    public function prePersistHandler(CartReadModel $cart, LifecycleEventArgs $event) {
        $this->setProductNameAndPrice($cart, $event->getEntityManager());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdateHandler(CartReadModel $cart, LifecycleEventArgs $event) {
        $this->setProductNameAndPrice($cart, $event->getEntityManager());
    }

    /**
     * @ORM\PreFlush
     */
    public function preFlashHandler(CartReadModel $cart, PreFlushEventArgs $event) {
        $this->setProductNameAndPrice($cart, $event->getEntityManager());
    }

    /**
     * @param CartReadModel $cart
     * @param EntityManager $entityManager
     * @throws \App\Product\Domain\Product\Exception\ProductNotFoundException
     */
    public function setProductNameAndPrice(CartReadModel $cart, EntityManager $entityManager) {
        $product = $this->productQueryService->getProduct(new ProductId($cart->getProductId()));

        $cart->setProductName($product->getProductName()->getName());
        $cart->setProductPrice($product->getProductPrice()->getPrice()->getAmount());
        $cart->setCurrency($product->getProductPrice()->getPrice()->getCurrency()->getCode());
    }
}