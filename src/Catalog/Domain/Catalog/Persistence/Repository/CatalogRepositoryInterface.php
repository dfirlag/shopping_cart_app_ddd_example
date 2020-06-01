<?php

namespace App\Catalog\Domain\Catalog\Persistence\Repository;

use App\Catalog\Domain\Catalog\Catalog;

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