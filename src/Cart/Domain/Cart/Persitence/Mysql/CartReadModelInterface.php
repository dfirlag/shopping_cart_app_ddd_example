<?php

namespace App\Cart\Domain\Cart\Persitence\Mysql;

/**
 * Class CartReadModelInterface
 *
 * @package App\Cart\Domain\Cart\Persitence\Mysql
 */
interface CartReadModelInterface {

    /**
     * @return string
     */
    public function getCartId(): string;

    /**
     * @param string $cartId
     */
    public function setCartId(string $cartId): void;

    /**
     * @return string
     */
    public function getProductName(): string;

    /**
     * @param string $productName
     */
    public function setProductName(string $productName): void;

    /**
     * @return int
     */
    public function getProductId(): int;

    /**
     * @param int $productId
     */
    public function setProductId(int $productId): void;

    /**
     * @return string
     */
    public function getProductPrice(): string ;

    /**
     * @param string $productPrice
     */
    public function setProductPrice(string $productPrice): void;

    /**
     * @return string
     */
    public function getCurrency(): string;

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void;
}