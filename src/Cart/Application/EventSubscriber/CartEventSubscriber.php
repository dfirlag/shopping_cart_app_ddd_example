<?php

declare(strict_types=1);

namespace App\Cart\Application\EventSubscriber;

use App\Cart\Application\CartReadModelCommandService;
use App\Cart\Domain\Cart\Event\CartCreatedEvent;
use App\Cart\Domain\Cart\Event\ProductAddedToCartEvent;
use App\Cart\Domain\Cart\Event\ProductRemovedFromCartEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CartEventSubscriber
 *
 * @package App\Cart\Application\EventSubscriber
 */
class CartEventSubscriber implements EventSubscriberInterface {

    /**
     * @var CartReadModelCommandService
     */
    private $cartReadModelService;

    /**
     * CartEventSubscriber constructor.
     *
     * @param CartReadModelCommandService $cartReadModelService
     */
    public function __construct(CartReadModelCommandService $cartReadModelService) {
        $this->cartReadModelService = $cartReadModelService;
    }

    /**
     * @return array|string[]
     */
    public static function getSubscribedEvents() {
        return [
            CartCreatedEvent::NAME => 'onCartCreated',
            ProductAddedToCartEvent::NAME => 'onProductAddedToCart',
            ProductRemovedFromCartEvent::NAME => 'onProductRemovedFromCart',
        ];
    }

    /**
     * @param ProductAddedToCartEvent $event
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function onProductAddedToCart(ProductAddedToCartEvent $event) {
        $this->cartReadModelService->createCartReadModel($event->getCartUuid(), $event->getProductId());
    }

    /**
     * @param CartCreatedEvent $event
     */
    public function onCartCreated(CartCreatedEvent $event) {
        // not implemented
    }

    /**
     * @param ProductRemovedFromCartEvent $event
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function onProductRemovedFromCart(ProductRemovedFromCartEvent $event) {
        $this->cartReadModelService->removeCartReadModel($event->getCartUuid(), $event->getProductId());
    }
}