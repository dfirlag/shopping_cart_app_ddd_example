<?php

declare(strict_types=1);

namespace App\Product\Domain\Product\Persistence;

interface ProductModel {

    public function getId(): int;
    public function setId(int $id): void;
    public function getName(): string;
    public function setName(string $name): void;
    public function getPrice(): string;
    public function setPrice(string $price): void;
    public function getCurrency(): string;
    public function setCurrency(string $currency): void;
}