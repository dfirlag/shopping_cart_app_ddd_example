<?php

declare(strict_types=1);

namespace App\Cart\Infrastructure\Persistence\Mysql\Repository;

use App\Cart\Domain\Cart\Persitence\Mysql\Repository\CartReadModelRepositoryInterface;
use App\Cart\Domain\Cart\ValueObject\CartUuid;
use App\Cart\Infrastructure\Persistence\Mysql\CartReadModel;
use App\Shared\Domain\ValueObject\ProductId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CartReadModelRepository
 *
 * @package App\Cart\Infrastructure\Persistence\Mysql\Repository
 */
class CartReadModelRepository extends ServiceEntityRepository implements CartReadModelRepositoryInterface {

    /**
     * ProductRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, CartReadModel::class);
    }

    /**
     * @param CartUuid  $cartUuid
     * @param ProductId $productId
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createCartReadModel(CartUuid $cartUuid, ProductId $productId) {
        $cartReadModel = new CartReadModel();
        $cartReadModel->setCartId($cartUuid->getUuid());
        $cartReadModel->setProductId($productId->getId());

        $this->getEntityManager()->persist($cartReadModel);
        $this->getEntityManager()->flush();
    }

    /**
     * @param ProductId $productId
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function refreshCartReadModels(ProductId $productId) {
        $models = $this->findBy([
            'productId' => $productId->getId()
        ]);

        if (empty($models)) {
            return;
        }

        foreach ($models as $model) {
            $this->getEntityManager()->persist($model);
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @param CartUuid  $cartUuid
     * @param ProductId $productId
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeCartReadModel(CartUuid $cartUuid, ProductId $productId) {
        $model = $this->findOneBy([
            'cartId' =>  $cartUuid->getUuid(),
            'productId' => $productId->getId()
        ]);

        if (!$model) {
            return;
        }

        $this->getEntityManager()->remove($model);
        $this->getEntityManager()->flush();
    }
}