<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Persistence\Mysql\Listener;

use App\Catalog\Infrastructure\Persistence\Mysql\Catalog;
use App\Product\Infrastructure\Persistence\Mysql\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CatalogListener
 *
 * @package App\Product\Infrastructure\Persistence\Mysql\Listener
 */
class CatalogListener {

    /**
     * @ORM\PrePersist
     */
    public function prePersistHandler(Catalog $catalog, LifecycleEventArgs $event) {
        $this->setProductIds($catalog, $event->getEntityManager());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdateHandler(Catalog $catalog, LifecycleEventArgs $event) {
        $this->setProductIds($catalog, $event->getEntityManager());
    }

    /**
     * @ORM\PreFlush
     */
    public function preFlashHandler(Catalog $catalog, PreFlushEventArgs $event) {
        $this->setProductIds($catalog, $event->getEntityManager());
    }

    /** @ORM\PostLoad */
    public function postLoadHandler(Catalog $catalog, LifecycleEventArgs $event)
    {
        $productsIds = [];
        foreach ($catalog->getProducts()->getIterator() as $row) {
            $productsIds[] = $row->getId();
        }

        $catalog->setProductIds($productsIds);
    }

    /**
     * @param Catalog       $catalog
     * @param EntityManager $entityManager
     */
    private function setProductIds(Catalog $catalog, EntityManager $entityManager) {
        $products = $entityManager
            ->getRepository(Product::class)
            ->findBy(['id' => $catalog->getProductIds()]);

        $catalog->setProducts($products);
    }
}