<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog\ValueObject;

/**
 * Class CartQueryProductCollection
 *
 * @package App\Cart\Domain\Cart\ValueObject
 */
class CatalogQueryProductCollection {

    /**
     * @var array
     */
    private $products = [];

    /**
     * @return CatalogQueryProductCollection
     */
    public static function createNewInstance(): CatalogQueryProductCollection {
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