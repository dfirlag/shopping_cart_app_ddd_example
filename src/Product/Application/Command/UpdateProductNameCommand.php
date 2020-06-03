<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Shared\Application\Command\CommandInterface;

/**
 * Class UpdateProductNameCommand
 *
 * @package App\Product\Application\Command
 */
final class UpdateProductNameCommand implements CommandInterface {

    /**
     * @var int
     */
    private $productId;

    /**
     * @var String
     */
    private $productName;

    /**
     * UpdateProductNameCommand constructor.
     *
     * @param int $productId
     * @param String $productName
     */
    public function __construct(int $productId, string $productName) {
        $this->productId = $productId;
        $this->productName = $productName;
    }

    /**
     * @return int
     */
    public function getProductId(): int {
        return $this->productId;
    }

    /**
     * @return String
     */
    public function getProductName(): string {
        return $this->productName;
    }
}