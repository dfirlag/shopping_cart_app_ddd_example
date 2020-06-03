<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog\Persistence;

/**
 * Interface CatalogReadModelInterface
 *
 * @package App\Catalog\Domain\Catalog\Persistence
 */
interface CatalogReadModelInterface {

    /**
     * @return int
     */
    public function getId(): int;
    /**
     * @param int $id
     */
    public function setId(int $id): void;

    /**
     * @return
     */
    public function getCatalog();

    /**
     * @param $catalog
     */
    public function setCatalog($catalog): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * @return
     */
    public function getProduct();

    /**
     * @param $product
     */
    public function setProduct($product): void;

    /**
     * @return string
     */
    public function getProductName(): string;

    /**
     * @param string $productName
     */
    public function setProductName(string $productName): void;

    /**
     * @return string
     */
    public function getProductPrice(): string;

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

    /**
     * @param int $catalog_id
     */
    public function setCatalogId(int $catalog_id): void;

    /**
     * @return int
     */
    public function getProductId(): int;

    /**
     * @param int $productId
     */
    public function setProductId(int $productId): void;
}