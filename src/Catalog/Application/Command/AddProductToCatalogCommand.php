<?php

declare(strict_types=1);

namespace App\Catalog\Application\Command;

use App\Shared\Application\Command\CommandInterface;

class AddProductToCatalogCommand implements CommandInterface {

    /**
     * @var int
     */
    private $catalogId;

    /**
     * @var int
     */
    private $productId;

    /**
     * AddProductToCatalogCommand constructor.
     *
     * @param int $catalogId
     * @param int $productId
     */
    public function __construct(int $catalogId, int $productId) {
        $this->catalogId = $catalogId;
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getCatalogId(): int {
        return $this->catalogId;
    }

    /**
     * @return int
     */
    public function getProductId(): int {
        return $this->productId;
    }
}