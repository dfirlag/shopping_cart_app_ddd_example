<?php

declare(strict_types=1);

namespace App\Cart\Domain\Cart\Persitence\Mysql;

interface CartModelInterface {

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $uuid
     */
    public function setId(string $uuid): void;

    /**
     * @param int $productId
     */
    public function addProductId(int $productId): void;

    /**
     * @param array $productIds
     */
    public function setProductIds(array $productIds): void;

    /**
     * @return array
     */
    public function getProductIds(): array;

    /**
     * @param array $products
     */
    public function setProducts(array $products): void;
}