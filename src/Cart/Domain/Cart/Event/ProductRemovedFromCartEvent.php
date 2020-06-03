<?php

declare(strict_types=1);

namespace App\Cart\Domain\Cart\Event;

use App\Cart\Domain\Cart\ValueObject\CartUuid;
use App\Shared\Domain\ValueObject\ProductId;

/**
 * Class ProductRemovedFromCartEvent
 *
 * @package App\Cart\Domain\Cart\Event
 */
class ProductRemovedFromCartEvent {

    public const NAME = "cart.product.removed";

    /**
     * @var CartUuid
     */
    private $cartUuid;

    /**
     * @var ProductId
     */
    private $productId;

    /**
     * ProductAddedToCartEvent constructor.
     *
     * @param CartUuid $cartUuid
     * @param ProductId    $productId
     */
    public function __construct(CartUuid $cartUuid, ProductId $productId) {
        $this->cartUuid = $cartUuid;
        $this->productId = $productId;
    }

    /**
     * @return CartUuid
     */
    public function getCartUuid(): CartUuid {
        return $this->cartUuid;
    }

    /**
     * @return ProductId
     */
    public function getProductId(): ProductId {
        return $this->productId;
    }
}