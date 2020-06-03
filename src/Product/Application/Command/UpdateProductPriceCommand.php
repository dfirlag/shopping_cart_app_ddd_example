<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Shared\Application\Command\CommandInterface;
use Money\Money;

/**
 * Class UpdateProductPriceCommand
 *
 * @package App\Product\Application\Command
 */
final class UpdateProductPriceCommand implements CommandInterface  {
    /**
     * @var int
     */
    private $productId;

    /**
     * @var Money
     */
    private $price;

    /**
     * UpdateProductPriceCommand constructor.
     *
     * @param int $productId
     * @param Money $price
     */
    public function __construct(int $productId, Money $price) {
        $this->productId = $productId;
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getProductId(): int {
        return $this->productId;
    }

    /**
     * @return Money
     */
    public function getPrice(): Money {
        return $this->price;
    }
}