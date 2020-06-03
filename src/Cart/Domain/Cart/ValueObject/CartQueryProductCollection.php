<?php

declare(strict_types=1);

namespace App\Cart\Domain\Cart\ValueObject;

/**
 * Class CartQueryProductCollection
 *
 * @package App\Cart\Domain\Cart\ValueObject
 */
class CartQueryProductCollection {

    /**
     * @var array
     */
    private $products = [];

    /**
     * @return CartQueryProductCollection
     */
    public static function createNewInstance(): CartQueryProductCollection {
        return new static();
    }

    /**
     * @param ProductQuery $productQuery
     */
    public function addProduct(ProductQuery $productQuery) {
        $this->products[$productQuery->getProductId()] = $productQuery;
    }

    /**
     * @return ProductQuery[]
     */
    public function getProducts(): array {
        return $this->products;
    }
}