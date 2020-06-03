<?php

declare(strict_types=1);

namespace App\Cart\Domain\Cart;

use App\Cart\Domain\Cart\ValueObject\CartQueryProductCollection;
use App\Cart\Domain\Cart\ValueObject\CartUuid;

/**
 * Class CartQuery
 *
 * @package App\Cart\Domain\Cart
 */
class CartQuery {

    /**
     * @var CartUuid
     */
    private $cartUuid;

    /**
     * @var CartQueryProductCollection
     */
    private $cartQueryProductCollection;

    /**
     * CartQuery constructor.
     *
     * @param CartUuid $cartUuid
     * @param CartQueryProductCollection $cartQueryProductCollection
     */
    public function __construct(CartUuid $cartUuid, CartQueryProductCollection $cartQueryProductCollection) {
        $this->cartUuid = $cartUuid;
        $this->cartQueryProductCollection = $cartQueryProductCollection;
    }

    /**
     * @return CartUuid
     */
    public function getCartUuid(): CartUuid {
        return $this->cartUuid;
    }

    /**
     * @return CartQueryProductCollection
     */
    public function getCartQueryProductCollection(): CartQueryProductCollection {
        return $this->cartQueryProductCollection;
    }
}