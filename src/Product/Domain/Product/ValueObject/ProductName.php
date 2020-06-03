<?php

declare(strict_types=1);

namespace App\Product\Domain\Product\ValueObject;

/**
 * Class ProductName
 *
 * @package App\Product\Domain\Product\ValueObject
 */
class ProductName {

    /**
     * @var String
     */
    private $productName;

    /**
     * ProductName constructor.
     *
     * @param String $productName
     */
    public function __construct(string $productName) { $this->productName = $productName; }

    /**
     * @return String
     */
    public function getName(): string {
        return $this->productName;
    }
}