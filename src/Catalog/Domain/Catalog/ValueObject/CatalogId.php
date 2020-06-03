<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog\ValueObject;

/**
 * Class CatalogId
 *
 * @package App\Catalog\Domain\Catalog\ValueObject
 */
class CatalogId {

    /**
     * @var int
     */
    private $id;

    /**
     * CatalogId constructor.
     *
     * @param int $id
     */
    public function __construct(int $id) { $this->id = $id; }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }
}