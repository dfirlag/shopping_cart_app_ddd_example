<?php

declare(strict_types=1);

namespace App\Product\Domain\Product\ValueObject;

class ProductId {

    /**
     * @var int
     */
    private $id;

    /**
     * ProductId constructor.
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