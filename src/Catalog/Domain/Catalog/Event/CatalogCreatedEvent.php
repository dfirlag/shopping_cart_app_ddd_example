<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog\Event;

/**
 * Class CatalogCreatedEvent
 *
 * @package App\Catalog\Domain\Catalog\Event
 */
class CatalogCreatedEvent {

    public const NAME = "catalog.created";

    /**
     * @var int
     */
    private $catalogId;

    /**
     * CatalogCreatedEvent constructor.
     *
     * @param string $catalogId
     */
    public function __construct(int $catalogId) {
        $this->catalogId = $catalogId;
    }

    /**
     * @return int
     */
    public function getCatalogId(): int {
        return $this->catalogId;
    }
}