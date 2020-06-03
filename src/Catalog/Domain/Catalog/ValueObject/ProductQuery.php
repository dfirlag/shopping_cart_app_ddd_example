<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog\ValueObject;

use Money\Money;

/**
 * Class ProductQuery
 *
 * @package App\Cart\Domain\Cart\ValueObject
 */
class ProductQuery {

    /**
     * @var int
     */
    private $productId;

    /**
     * @var string
     */
    private $productName;

    /**
     * @var Money
     */
    private $productPrice;

    /**
     * ProductQuery constructor.
     *
     * @param int    $productId
     * @param string $productName
     * @param Money  $productPrice
     */
    public function __construct(int $productId, string $productName, Money $productPrice) {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->productPrice = $productPrice;
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
    public function getProductName(): string {
        return $this->productName;
    }

    /**
     * @return Money
     */
    public function getProductPrice(): Money {
        return $this->productPrice;
    }
}