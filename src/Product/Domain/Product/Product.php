<?php

declare(strict_types=1);

namespace App\Product\Domain\Product;

use App\Product\Domain\Product\ValueObject\ProductPrice;
use App\Shared\Domain\ValueObject\ProductId;
use App\Product\Domain\Product\ValueObject\ProductName;

class Product {

    /**
     * @var ProductId
     */
    private $productId;

    /**
     * @var ProductName
     */
    private $productName;

    /**
     * @var ProductPrice
     */
    private $productPrice;

    /**
     * Product constructor.
     *
     * @param ProductId    $productId
     * @param ProductName  $productName
     * @param ProductPrice $productPrice
     */
    public function __construct(?ProductId $productId, ProductName $productName, ProductPrice $productPrice) {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->productPrice = $productPrice;
    }

    public function updateProductPrice(ProductPrice $productPrice): void {
        $this->productPrice = $productPrice;
    }

    public function updateProductName(ProductName $productName): void {
        $this->productName = $productName;
    }

    /**
     * @return ProductId
     */
    public function getProductId(): ?ProductId
    {
        return $this->productId;
    }

    /**
     * @return ProductName
     */
    public function getProductName(): ProductName
    {
        return $this->productName;
    }

    /**
     * @return ProductPrice
     */
    public function getProductPrice(): ProductPrice
    {
        return $this->productPrice;
    }
}