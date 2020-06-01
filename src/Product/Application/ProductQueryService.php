<?php

declare(strict_types=1);

namespace App\Product\Application;

use App\Product\Domain\Product\Factory\ProductFactory;
use Money\Money;

class ProductQueryService {

    public function getTotalAmountFromProducts(array $products): Money {
        $total = Money::PLN(0);

        foreach ($products as $productModel) {
            $product = ProductFactory::createFromModel($productModel);

            $total->add($product->getProductPrice()->getPrice());
        }

        return $total;
    }
}