<?php

declare(strict_types=1);

namespace App\Product\Domain\Product\Persistence\Repository;

use App\Product\Domain\Product\Product;

interface ProductRepositoryInterface {

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param Product $product
     */
    public function saveProduct(Product $product): void;
}