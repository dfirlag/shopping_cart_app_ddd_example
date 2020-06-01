<?php

declare(strict_types=1);

namespace App\Cart\Application;

use App\Cart\Domain\Cart\Exception\InvalidCartUuidException;
use App\Cart\Domain\Cart\ValueObject\CartUuid;
use App\Cart\Infrastructure\Persistence\Mysql\Repository\CartRepository;

class CartCommandService {

    /**
     * @var CartRepository
     */
    private $cartRepository;

    /**
     * CartCommandService constructor.
     *
     * @param CartRepository $cartRepository
     */
    public function __construct(CartRepository $cartRepository) {
        $this->cartRepository = $cartRepository;
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

        $this->cartRepository->createEmpty($cartUuid);
    }

    public function createNewCartUuid(): string {
        return uuid_create(UUID_TYPE_RANDOM);
    }
}