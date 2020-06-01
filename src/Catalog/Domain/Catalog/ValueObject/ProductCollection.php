<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog\ValueObject;

class ProductCollection {

    /**
     * @var array
     */
    private $productIds = [];

    public static function createFromArray(array $productIds): ProductCollection {
        $instance = new self();
        $instance->productIds = $productIds;
        return $instance;
    }

    /**
     * @param ProductId $productId
     */
    public function addProductId(ProductId $productId): void {
        $this->productIds[$productId->getId()] = $productId;
    }

    /**
     * @param ProductId $productId
     */
    public function removeProductId(ProductId $productId): void {
        if (isset($this->productIds[$productId->getId()])) {
            unset($this->productIds[$productId->getId()]);
        }
    }

    public function toArray(): array {
        return array_keys($this->productIds);
    }
}