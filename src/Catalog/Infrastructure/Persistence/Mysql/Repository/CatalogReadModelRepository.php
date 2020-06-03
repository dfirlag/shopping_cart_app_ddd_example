<?php

declare(strict_types=1);

namespace App\Catalog\Infrastructure\Persistence\Mysql\Repository;

use App\Catalog\Domain\Catalog\Persistence\Repository\CatalogReadModelRepositoryInterface;
use App\Catalog\Domain\Catalog\ValueObject\CatalogId;
use App\Catalog\Domain\Catalog\ValueObject\CatalogName;
use App\Catalog\Infrastructure\Persistence\Mysql\Catalog;
use App\Catalog\Infrastructure\Persistence\Mysql\CatalogReadModel;
use App\Shared\Domain\ValueObject\ProductId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CatalogReadModelRepository
 *
 * @package App\Catalog\Infrastructure\Persistence\Mysql\Repository
 */
class CatalogReadModelRepository extends ServiceEntityRepository  implements CatalogReadModelRepositoryInterface {

    /**
     * ProductRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, CatalogReadModel::class);
    }

    /**
     * @param CatalogName $catalogName
     * @param CatalogId   $catalogId
     * @param ProductId   $productId
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createCatalogReadModel(CatalogName $catalogName, CatalogId $catalogId, ProductId $productId) {
        $catalogModel = $this->getEntityManager()->getRepository(Catalog::class)
            ->find($catalogId->getId());

        $cartReadModel = new CatalogReadModel();
        $cartReadModel->setCatalog($catalogModel);
        $cartReadModel->setName($catalogName->getName());
        $cartReadModel->setCatalogId($catalogId->getId());
        $cartReadModel->setProductId($productId->getId());

        $this->getEntityManager()->persist($cartReadModel);
        $this->getEntityManager()->flush();
    }

    /**
     * @param ProductId $productId
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function refreshCatalogReadModels(ProductId $productId) {
        $models = $this->findBy([
            'product' => $productId->getId()
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
     * @param CatalogId $catalogId
     * @param ProductId $productId
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeCatalogReadModel(CatalogId $catalogId, ProductId $productId) {
        $model = $this->findOneBy([
            'catalog' =>  $catalogId->getId(),
            'product' => $productId->getId()
        ]);

        if (!$model) {
            return;
        }

        $this->getEntityManager()->remove($model);
        $this->getEntityManager()->flush();
    }

    /**
     * @param CatalogId $catalogId
     * @param int       $page
     * @param int       $itemPerPage
     * @return \ArrayIterator|mixed|\Traversable
     * @throws \Exception
     */
    public function getPaginated(CatalogId $catalogId, int $page, int $itemPerPage) {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from(CatalogReadModel::class, 'c')
            ->where('c.catalog = :id')
            ->setParameter('id', $catalogId->getId())
            ->orderBy('c.id', 'DESC')
            ->getQuery();

        $paginator = new Paginator($query);
        $paginator
            ->getQuery()
            ->setFirstResult($itemPerPage * ($page - 1))
            ->setMaxResults($itemPerPage);

        return $paginator;
    }
}