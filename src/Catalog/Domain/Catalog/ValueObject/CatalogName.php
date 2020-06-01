<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog\ValueObject;

class CatalogName {

    /**
     * @var string
     */
    private $name;

    /**
     * CatalogName constructor.
     *
     * @param string $name
     */
    public function __construct(string $name) { $this->name = $name; }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }
}