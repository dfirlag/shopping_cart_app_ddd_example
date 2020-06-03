<?php

declare(strict_types=1);

namespace App\Product\Domain\Product\Persistence;

/**
 * Interface ProductModel
 *
 * @package App\Product\Domain\Product\Persistence
 */
interface ProductModel {

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
     * @return string
     */
    public function getPrice(): string;

    /**
     * @param string $price
     */
    public function setPrice(string $price): void;

    /**
     * @return string
     */
    public function getCurrency(): string;

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void;
}