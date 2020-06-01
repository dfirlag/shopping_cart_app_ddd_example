<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog\Persistence;

interface CatalogModelInterface {

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     */
    public function setId(int $id): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * @param mixed $products
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
}