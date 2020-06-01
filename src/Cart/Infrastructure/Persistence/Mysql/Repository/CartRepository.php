<?php

namespace App\Cart\Infrastructure\Persistence\Mysql\Repository;

use App\Cart\Domain\Persitence\Mysql\Repository\CartRepositoryInterface;
use App\Cart\Domain\Cart\ValueObject\CartUuid;
use App\Cart\Infrastructure\Persistence\Mysql\Cart as CartModel;
use App\Catalog\Domain\Catalog\Catalog;
use App\Catalog\Domain\Catalog\Persistence\Repository\CatalogRepositoryInterface;
use App\Product\Infrastructure\Persistence\Mysql\Product as ProductModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Catalog\Infrastructure\Persistence\Mysql\Catalog as CatalogModel;

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



    //    /**
//     * @param Catalog $catalog
//     * @throws \Doctrine\ORM\ORMException
//     * @throws \Doctrine\ORM\OptimisticLockException
//     */
//    public function saveCart(Cart $catalog): void
//    {
//        if ($catalog->getCatalogId() !== null) {
//            $catalogModel = $this->find($catalog->getCatalogId()->getId());
//        } else {
//            $catalogModel = new CatalogModel();
//        }
//
//        $catalogModel->setName($catalog->getCatalogName()->getName());
//        $catalogModel->setProductIds($catalog->getProductCollection()->toArray());
//
//        $this->getEntityManager()->persist($catalogModel);
//        $this->getEntityManager()->flush();
//    }
}