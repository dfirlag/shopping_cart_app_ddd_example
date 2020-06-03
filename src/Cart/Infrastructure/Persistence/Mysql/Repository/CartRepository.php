<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Persistence\Mysql\Repository;

use App\Cart\Domain\Cart\Cart;
use App\Cart\Domain\Cart\Persitence\Mysql\Repository\CartRepositoryInterface;
use App\Cart\Domain\Cart\ValueObject\CartUuid;
use App\Cart\Infrastructure\Persistence\Mysql\Cart as CartModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CartRepository
 *
 * @package App\Cart\Infrastructure\Persistence\Mysql\Repository
 */
class CartRepository extends ServiceEntityRepository implements CartRepositoryInterface {

    /**
     * ProductRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, CartModel::class);
    }

    /**
     * @param CartUuid $cartUuid
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException+
     */
    public function createEmpty(CartUuid $cartUuid): void {
        $cartModel = new CartModel();
        $cartModel->setId($cartUuid->getUuid());

        $this->getEntityManager()->persist($cartModel);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Cart $cart
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveCart(Cart $cart): void
    {
        if ($cart->getCartUuid() !== null) {
            $cartModel = $this->find($cart->getCartUuid()->getUuid());
        } else {
            $cartModel = new CartModel();
        }

        $cartModel->setProductIds($cart->getProductCollection()->toArray());

        $this->getEntityManager()->persist($cartModel);
        $this->getEntityManager()->flush();
    }
}