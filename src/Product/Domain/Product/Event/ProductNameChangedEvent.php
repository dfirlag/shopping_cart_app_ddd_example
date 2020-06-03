<?php

declare(strict_types=1);

namespace App\Product\Domain\Product\Event;

/**
 * Class ProductNameChangedEvent
 *
 * @package App\Product\Domain\Product\Event
 */
class ProductNameChangedEvent {

    /**
     * @var int
     */
    private $productId;

    /**
     * @var string
     */
    private $changedName;

    /**
     * ProductNameChangedEvent constructor.
     *
     * @param int    $productId
     * @param string $changedName
     */
    public function __construct(int $productId, string $changedName) {
        $this->productId = $productId;
        $this->changedName = $changedName;
    }

    /**
     * @return int
     */
    public function getProductId(): int {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function getChangedName(): string {
        return $this->changedName;
    }
}