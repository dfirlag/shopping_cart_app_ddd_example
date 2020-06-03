<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog;

use App\Catalog\Domain\Catalog\ValueObject\CatalogQueryProductCollection;
use App\Catalog\Domain\Catalog\ValueObject\CatalogId;

class CatalogQuery {

    /**
     * @var CatalogId
     */
    private $catalogId;

    /**
     * @var CatalogQueryProductCollection
     */
    private $catalogProductCollection;

    /**
     * CatalogQuery constructor.
     *
     * @param CatalogId $catalogId
     */
    public function __construct(CatalogId $catalogId) {
        $this->catalogId = $catalogId;
        $this->catalogProductCollection = CatalogQueryProductCollection::createNewInstance();
    }

    /**
     * @return CatalogId
     */
    public function getCatalogId(): CatalogId {
        return $this->catalogId;
    }

    /**
     * @return CatalogQueryProductCollection
     */
    public function getCatalogProductCollection(): CatalogQueryProductCollection {
        return $this->catalogProductCollection;
    }
}