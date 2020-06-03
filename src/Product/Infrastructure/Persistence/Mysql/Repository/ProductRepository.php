<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Persistence\Mysql\Repository;

use App\Product\Domain\Product\Persistence\Repository\ProductRepositoryInterface;
use App\Product\Domain\Product\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Product\Infrastructure\Persistence\Mysql\Product as ProductModel;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class ProductRepository
 *
 * @package App\Product\Infrastructure\Persistence\Mysql\Repository
 */
class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface {

    /**
     * ProductRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, ProductModel::class);
    }

    /**
     * @param Product $product
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveProduct(Product $product): void
    {
        if ($product->getProductId() !== null) {
            $productModel = $this->find($product->getProductId()->getId());
        } else {
            $productModel = new ProductModel();
        }

        $productModel->setName($product->getProductName()->getName());
        $productModel->setPrice($product->getProductPrice()->getPrice()->getAmount());
        $productModel->setCurrency($product->getProductPrice()->getPrice()->getCurrency()->getCode());

        $this->getEntityManager()->persist($productModel);
        $this->getEntityManager()->flush();
    }
}