<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog\Event;

use App\Shared\Domain\ValueObject\ProductId;

/**
 * Class ProductAddedToCartEvent
 *
 * @package App\Cart\Domain\Cart\Event
 */
class ProductAddedToCatalogEvent {

    public const NAME = "catalog.product.added";

    /**
     * @var int
     */
    private $catalogId;

    /**
     * @var string
     */
    private $catalogName;

    /**
     * @var ProductId
     */
    private $productId;

    /**
     * ProductAddedToCatalogEvent constructor.
     *
     * @param int       $catalogId
     * @param string    $catalogName
     * @param ProductId $productId
     */
    public function __construct(int $catalogId, string $catalogName, ProductId $productId) {
        $this->catalogId = $catalogId;
        $this->catalogName = $catalogName;
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

    /**
     * @return string
     */
    public function getCatalogName(): string {
        return $this->catalogName;
    }
}