<?php

declare(strict_types=1);

namespace App\Cart\Domain\Cart\Builder;

use App\Cart\Domain\Cart\CartQuery;
use App\Cart\Domain\Cart\ValueObject\CartQueryProductCollection;
use App\Cart\Domain\Cart\ValueObject\CartUuid;
use App\Cart\Domain\Cart\ValueObject\ProductQuery;
use Money\Money;

/**
 * Class CartQueryBuilder
 *
 * @package App\Cart\Domain\Cart\Builder
 */
class CartQueryBuilder {

    /**
     * @var CartUuid
     */
    private $cartUuid;

    /**
     * @var CartQueryProductCollection
     */
    private $productCollection;

    /**
     * CartQueryBuilder constructor.
     */
    public function __construct() {
        $this->productCollection = CartQueryProductCollection::createNewInstance();
    }

    /**
     * @return CartQueryBuilder
     */
    public static function create(): CartQueryBuilder {
        return new self();
    }

    /**
     * @param CartUuid $cartUuid
     */
    public function setCartUuid(CartUuid $cartUuid): CartQueryBuilder {
        $this->cartUuid = $cartUuid;
        return $this;
    }

    /**
     * @param int    $productId
     * @param string $productName
     * @param Money  $price
     */
    public function addProduct(int $productId, string $productName, Money $price) {
        $this->productCollection->addProduct(new ProductQuery(
            $productId,
            $productName,
            $price
        ));
    }

    /**
     * @return CartQuery
     */
    public function build(): CartQuery {
        return new CartQuery(
            $this->cartUuid,
            $this->productCollection
        );
    }
}