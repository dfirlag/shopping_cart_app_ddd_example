<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

/**
 * Class ProductId
 *
 * @package App\Catalog\Domain\Catalog\ValueObject
 */
class ProductId {

    /**
     * @var int
     */
    private $id;

    /**
     * CatalogId constructor.
     *
     * @param int $id
     */
    public function __construct(int $id) {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }
}