<?php

declare(strict_types=1);

namespace App\Catalog\Application\EventSubscriber;

use App\Catalog\Application\CatalogReadModelCommandService;
use App\Catalog\Domain\Catalog\Event\CatalogCreatedEvent;
use App\Catalog\Domain\Catalog\Event\ProductAddedToCatalogEvent;
use App\Catalog\Domain\Catalog\Event\ProductRemovedFromCatalogEvent;
use App\Catalog\Domain\Catalog\ValueObject\CatalogId;
use App\Catalog\Domain\Catalog\ValueObject\CatalogName;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CartEventSubscriber
 *
 * @package App\Cart\Application\EventSubscriber
 */
class CatalogEventSubscriber implements EventSubscriberInterface {

    /**
     * @var CatalogReadModelCommandService
     */
    private $catalogReadModelService;

    /**
     * CartEventSubscriber constructor.
     *
     * @param CatalogReadModelCommandService $catalogReadModelService
     */
    public function __construct(CatalogReadModelCommandService $catalogReadModelService) {
        $this->catalogReadModelService = $catalogReadModelService;
    }

    /**
     * @return array|string[]
     */
    public static function getSubscribedEvents() {
        return [
            CatalogCreatedEvent::NAME => 'onCatalogCreated',
            ProductAddedToCatalogEvent::NAME => 'onCatalogProductAdded',
            ProductRemovedFromCatalogEvent::NAME => 'onCatalogProductRemoved',
        ];
    }

    /**
     * @param ProductAddedToCatalogEvent $event
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function onCatalogProductAdded(ProductAddedToCatalogEvent $event) {
        $this->catalogReadModelService->createCatalogReadModel(
            new CatalogName($event->getCatalogName()),
            new CatalogId($event->getCatalogId()),
            $event->getProductId()
        );
    }

    /**
     * @param CatalogCreatedEvent $event
     */
    public function onCatalogCreated(CatalogCreatedEvent $event) {
        // not implemented
    }

    /**
     * @param ProductRemovedFromCatalogEvent $event
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function onCatalogProductRemoved(ProductRemovedFromCatalogEvent $event) {
        $this->catalogReadModelService->removeCatalogReadModel(new CatalogId($event->getCatalogId()), $event->getProductId());
    }
}