<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog\Event;

use App\Shared\Domain\ValueObject\ProductId;

/**
 * Class ProductRemovedFromCartEvent
 *
 * @package App\Cart\Domain\Cart\Event
 */
class ProductRemovedFromCatalogEvent {

    public const NAME = "catalog.product.removed";

    /**
     * @var int
     */
    private $catalogId;

    /**
     * @var ProductId
     */
    private $productId;

    /**
     * ProductRemovedFromCartEvent constructor.
     *
     * @param int    $catalogId
     * @param ProductId $productId
     */
    public function __construct(int $catalogId, ProductId $productId) {
        $this->catalogId = $catalogId;
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getCatalogId(): int {
        return $this->catalogId;
    }

    /**
     * @return ProductId
     */
    public function getProductId(): ProductId {
        return $this->productId;
    }
}