<?php

declare(strict_types=1);

namespace App\Cart\Domain\Cart\ValueObject;

use App\Cart\Domain\Cart\Cart;
use App\Cart\Domain\Cart\Exception\CartProductLimitExtendedException;
use App\Shared\Domain\ValueObject\ProductCollection;
use App\Shared\Domain\ValueObject\ProductId;

/**
 * Class CartProductCollection
 *
 * @package App\Cart\Domain\Cart\ValueObject
 */
class CartProductCollection extends ProductCollection {

    /**
     * @param ProductId $productId
     * @throws CartProductLimitExtendedException
     */
    public function addProductId(ProductId $productId): void {
        $this->productIds[$productId->getId()] = $productId;

        if ($this->count() > Cart::MAX_CART_PRODUCT_COUNT) {
            throw new CartProductLimitExtendedException();
        }
    }
}