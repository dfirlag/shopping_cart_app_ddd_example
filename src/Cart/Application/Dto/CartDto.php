<?php

declare(strict_types=1);

namespace App\Cart\Application\Dto;

use App\Cart\Domain\Cart\CartQuery;
use Money\Money;

/**
 * Class CartDto
 *
 * @package App\Cart\Application\Dto
 */
class CartDto {

    /**
     * @var CartQuery
     */
    private $cartQuery;

    /**
     * CartDto constructor.
     *
     * @param CartQuery $cartQuery
     */
    public function __construct(CartQuery $cartQuery) { $this->cartQuery = $cartQuery; }

    /**
     * @return CartQuery
     */
    public function getCartQuery(): CartQuery {
        return $this->cartQuery;
    }

    /**
     * @return false|string
     */
    public function __toString() {
        $data['cartId'] = $this->cartQuery->getCartUuid()->getUuid();
        $total = Money::PLN(0);

        foreach ($this->cartQuery->getCartQueryProductCollection()->getProducts() as $product) {
            $data['products'][] = [
                'price' => $product->getProductPrice()->getAmount(),
                'currency' => $product->getProductPrice()->getCurrency(),
                'name' => $product->getProductName(),
                'id' => $product->getProductId(),
            ];

            $total = $total->add($product->getProductPrice());
        }

        $data['total'] = $total->getAmount();
        return json_encode($data);
    }
}