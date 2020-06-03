<?php

declare(strict_types=1);

namespace App\Cart\Domain\Cart;

use App\Cart\Domain\Cart\ValueObject\CartUuid;
use App\Shared\Domain\ValueObject\ProductCollection;
use Money\Money;

/**
 * Class Cart
 *
 * @package App\Cart\Domain\Cart
 */
class Cart {

    const MAX_CART_PRODUCT_COUNT = 3;

    /**
     * @var CartUuid
     */
    private $cartUuid;

    /**
     * @var ProductCollection
     */
    private $productCollection;

    /**
     * @var Money
     */
    private $total;

    /**
     * Cart constructor.
     *
     * @param CartUuid          $cartUuid
     * @param ProductCollection $productCollection
     * @param Money             $total
     */
    public function __construct(CartUuid $cartUuid, ProductCollection $productCollection, Money $total) {
        $this->cartUuid = $cartUuid;
        $this->productCollection = $productCollection;
        $this->total = $total;
    }

    /**
     * @return CartUuid
     */
    public function getCartUuid(): CartUuid {
        return $this->cartUuid;
    }

    /**
     * @return ProductCollection
     */
    public function getProductCollection(): ProductCollection {
        return $this->productCollection;
    }

    /**
     * @return Money
     */
    public function getTotal(): Money {
        return $this->total;
    }
}