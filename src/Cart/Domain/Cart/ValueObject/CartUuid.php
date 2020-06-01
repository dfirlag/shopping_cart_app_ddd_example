<?php

declare(strict_types=1);

namespace App\Cart\Domain\Cart\ValueObject;

class CartUuid {

    /**
     * @var string
     */
    private $uuid;

    /**
     * CartUuid constructor.
     *
     * @param string $uuid
     */
    public function __construct(string $uuid) { $this->uuid = $uuid; }

    /**
     * @return string
     */
    public function getUuid(): string {
        return $this->uuid;
    }
}