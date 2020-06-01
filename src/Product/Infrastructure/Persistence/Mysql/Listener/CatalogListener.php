<?php

declare(strict_types=1);

namespace Product\Infrastructure\Persistence\Mysql\Listener;

use App\Catalog\Infrastructure\Persistence\Mysql\Catalog;
use App\Product\Infrastructure\Persistence\Mysql\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PreFlush;

class CatalogListener {

    /**
     * @PrePersist
     */
    public function prePersistHandler(Catalog $catalog, LifecycleEventArgs $event) {
        $this->setProductIds($catalog, $event->getEntityManager());
    }

    /**
     * @PreUpdate
     */
    public function preUpdateHandler(Catalog $catalog, LifecycleEventArgs $event) {
        $this->setProductIds($catalog, $event->getEntityManager());
    }

    /**
     * @PreFlush
     */
    public function preFlashHandler(Catalog $catalog, PreFlushEventArgs $event) {
        $this->setProductIds($catalog, $event->getEntityManager());
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