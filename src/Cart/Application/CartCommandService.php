<?php

declare(strict_types=1);

namespace App\Cart\Application;

use App\Cart\Domain\Cart\Event\CartCreatedEvent;
use App\Cart\Domain\Cart\Event\ProductAddedToCartEvent;
use App\Cart\Domain\Cart\Event\ProductRemovedFromCartEvent;
use App\Cart\Domain\Cart\Exception\InvalidCartUuidException;
use App\Cart\Domain\Cart\Factory\CartFactory;
use App\Cart\Domain\Cart\ValueObject\CartUuid;
use App\Cart\Infrastructure\Persistence\Mysql\Repository\CartRepository;
use App\Shared\Application\Event\EventDispatcher;
use App\Shared\Domain\ValueObject\ProductId;

/**
 * Class CartCommandService
 *
 * @package App\Cart\Application
 */
class CartCommandService {

    /**
     * @var CartRepository
     */
    private $cartRepository;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * CartCommandService constructor.
     *
     * @param CartRepository $cartRepository
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(CartRepository $cartRepository, EventDispatcher $eventDispatcher) {
        $this->cartRepository = $cartRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param CartUuid $cartUuid
     * @throws InvalidCartUuidException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createEmptyCart(CartUuid $cartUuid): void {
        if (!uuid_is_valid($cartUuid->getUuid())) {
            throw new InvalidCartUuidException();
        }

        //start transaction;
        $this->cartRepository->createEmpty($cartUuid);
        $this->eventDispatcher->dispatch(new CartCreatedEvent($cartUuid->getUuid()), CartCreatedEvent::NAME);
        //end transaction;
    }

    /**
     * @param CartUuid  $cartUuid
     * @param ProductId $productId
     * @throws \App\Cart\Domain\Cart\Exception\CartNotFoundException
     */
    public function addProductToCart(CartUuid $cartUuid, ProductId $productId) {
        $cart = CartFactory::createById($cartUuid, $this->cartRepository);

        $cart->getProductCollection()->addProductId($productId);

        $this->cartRepository->saveCart($cart);
        $this->eventDispatcher->dispatch(
            new ProductAddedToCartEvent($cartUuid, $productId),
            ProductAddedToCartEvent::NAME
        );
    }

    /**
     * @param CartUuid  $cartUuid
     * @param ProductId $productId
     * @throws \App\Cart\Domain\Cart\Exception\CartNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeProductFromCart(CartUuid $cartUuid, ProductId $productId) {
        $cart = CartFactory::createById($cartUuid, $this->cartRepository);

        $cart->getProductCollection()->removeProductId($productId);

        $this->cartRepository->saveCart($cart);
        $this->eventDispatcher->dispatch(
            new ProductRemovedFromCartEvent($cartUuid, $productId),
            ProductRemovedFromCartEvent::NAME
        );
    }

    /**
     * @return string
     */
    public function createNewCartUuid(): string {
        return uuid_create(UUID_TYPE_RANDOM);
    }
}