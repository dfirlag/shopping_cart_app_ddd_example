<?php

namespace App\Catalog\Infrastructure\Persistence\Mysql\Repository;

use App\Catalog\Domain\Catalog\Catalog;
use App\Catalog\Domain\Catalog\Persistence\Repository\CatalogRepositoryInterface;
use App\Product\Infrastructure\Persistence\Mysql\Product as ProductModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Catalog\Infrastructure\Persistence\Mysql\Catalog as CatalogModel;

class CatalogRepository extends ServiceEntityRepository implements CatalogRepositoryInterface {

    /**
     * ProductRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, CatalogModel::class);
    }

    /**
     * @param Catalog $catalog
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function saveCatalog(Catalog $catalog): void
    {
        if ($catalog->getCatalogId() !== null) {
            $catalogModel = $this->find($catalog->getCatalogId()->getId());
        } else {
            $catalogModel = new CatalogModel();
        }

        $catalogModel->setName($catalog->getCatalogName()->getName());
        $catalogModel->setProductIds($catalog->getProductCollection()->toArray());

        $this->getEntityManager()->persist($catalogModel);
        $this->getEntityManager()->flush();
    }
}