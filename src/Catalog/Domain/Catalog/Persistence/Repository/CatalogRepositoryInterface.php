<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog\Persistence\Repository;

use App\Catalog\Domain\Catalog\Catalog;

/**
 * Interface CatalogRepositoryInterface
 *
 * @package App\Catalog\Domain\Catalog\Persistence\Repository
 */
interface CatalogRepositoryInterface {

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param Catalog $product
     */
    public function saveCatalog(Catalog $product): void;
}