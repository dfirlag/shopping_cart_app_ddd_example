<?php

declare(strict_types=1);

namespace App\Cart\Application;

use App\Cart\Domain\Cart\ValueObject\CartUuid;
use App\Cart\Infrastructure\Persistence\Mysql\Repository\CartReadModelRepository;
use App\Shared\Domain\ValueObject\ProductId;

class CartReadModelCommandService {

    /**
     * @var CartReadModelRepository
     */
    private $cartReadModelRepository;

    /**
     * CartReadModelCommandService constructor.
     *
     * @param CartReadModelRepository $cartReadModelRepository
     */
    public function __construct(CartReadModelRepository $cartReadModelRepository) {
        $this->cartReadModelRepository = $cartReadModelRepository;
    }

    /**
     * @param CartUuid  $cartUuid
     * @param ProductId $productId
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createCartReadModel(CartUuid $cartUuid, ProductId $productId) {
        $this->cartReadModelRepository->createCartReadModel($cartUuid, $productId);
    }

    /**
     * @param ProductId $productId
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function refreshCartReadModel(ProductId $productId) {
        $this->cartReadModelRepository->refreshCartReadModels($productId);
    }

    /**
     * @param CartUuid  $cartUuid
     * @param ProductId $productId
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeCartReadModel(CartUuid $cartUuid, ProductId $productId) {
        $this->cartReadModelRepository->createCartReadModel($cartUuid, $productId);
    }
}