<?php

declare(strict_types=1);

namespace App\Catalog\Application\Dto;

use App\Catalog\Domain\Catalog\CatalogQuery;

/**
 * Class PaginatedCatalogDto
 *
 * @package App\Catalog\Application\Dto
 */
class PaginatedCatalogDto {

    /**
     * @var CatalogQuery
     */
    private $catalogQuery;

    /**
     * PaginatedCatalogDto constructor.
     *
     * @param CatalogQuery $catalogQuery
     */
    public function __construct(CatalogQuery $catalogQuery) { $this->catalogQuery = $catalogQuery; }

    /**
     * @return string
     */
    public function __toString(): string {
        $data['catalogId'] = $this->catalogQuery->getCatalogId()->getId();

        foreach ($this->catalogQuery->getCatalogProductCollection()->getProducts() as $product) {
            $data['products'][] = [
                'id' => $product->getProductId(),
                'name' => $product->getProductName(),
                'price' => $product->getProductPrice()->getAmount(),
                'currency' => $product->getProductPrice()->getCurrency(),
            ];
        }

        return json_encode($data);
    }
}