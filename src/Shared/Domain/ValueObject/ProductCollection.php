<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

/**
 * Class ProductCollection
 *
 * @package App\Shared\Domain\ValueObject
 */
class ProductCollection {

    /**
     * @var array
     */
    protected $productIds = [];

    /**
     * @param array $productIds
     * @return ProductCollection
     */
    public static function createFromArray(array $productIds): ProductCollection {
        $instance = new static();
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

    /**
     * @return array
     */
    public function toArray(): array {
        return array_keys($this->productIds);
    }

    /**
     * @return int
     */
    public function count(): int {
        return count($this->productIds);
    }
}