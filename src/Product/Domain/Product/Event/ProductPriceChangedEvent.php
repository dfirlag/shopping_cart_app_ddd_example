<?php

declare(strict_types=1);

namespace App\Product\Domain\Product\Event;

class ProductPriceChangedEvent {

    /**
     * @var int
     */
    private $productId;

    /**
     * @var string
     */
    private $changedPrice;

    /**
     * ProductNameChangedEvent constructor.
     *
     * @param int    $productId
     * @param string $changedName
     */
    public function __construct(int $productId, string $changedName) {
        $this->productId = $productId;
        $this->changedPrice = $changedName;
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
    public function getChangedPrice(): string {
        return $this->changedPrice;
    }
}