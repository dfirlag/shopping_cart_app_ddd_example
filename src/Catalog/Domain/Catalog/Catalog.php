<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog;

use App\Catalog\Domain\Catalog\ValueObject\CatalogId;
use App\Catalog\Domain\Catalog\ValueObject\CatalogName;
use App\Catalog\Domain\Catalog\ValueObject\ProductCollection;

class Catalog {

    /**
     * @var CatalogId
     */
    private $catalogId;

    /**
     * @var CatalogName
     */
    private $catalogName;

    /**
     * @var ProductCollection
     */
    private $productCollection;

    /**
     * Catalog constructor.
     *
     * @param CatalogId         $catalogId
     * @param CatalogName       $catalogName
     * @param ProductCollection $productCollection
     */
    public function __construct(CatalogId $catalogId, CatalogName $catalogName, ProductCollection $productCollection) {
        $this->catalogId = $catalogId;
        $this->catalogName = $catalogName;
        $this->productCollection = $productCollection;
    }

    /**
     * @return CatalogId
     */
    public function getCatalogId(): CatalogId {
        return $this->catalogId;
    }

    /**
     * @return CatalogName
     */
    public function getCatalogName(): CatalogName {
        return $this->catalogName;
    }

    /**
     * @return ProductCollection
     */
    public function getProductCollection(): ProductCollection {
        return $this->productCollection;
    }
}