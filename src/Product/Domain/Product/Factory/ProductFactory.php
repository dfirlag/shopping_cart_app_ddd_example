<?php

namespace App\Product\Domain\Product\Factory;

use App\Product\Domain\Product\Exception\ProductNotFoundException;
use App\Product\Domain\Product\Persistence\ProductModel;
use App\Product\Domain\Product\Persistence\Repository\ProductRepositoryInterface;
use App\Product\Domain\Product\Product;
use App\Product\Domain\Product\ValueObject\ProductId;
use App\Product\Domain\Product\ValueObject\ProductName;
use App\Product\Domain\Product\ValueObject\ProductPrice;
use Money\Currency;
use Money\Money;

class ProductFactory {

    public static function createFromModel(ProductModel $productModel): Product
    {
        return new Product(
            new ProductId($productModel->getId()),
            new ProductName($productModel->getName()),
            new ProductPrice(Money::PLN($productModel->getPrice(), new Currency($productModel->getCurrency())))
        );
    }

    /**
     * @param ProductId                  $productId
     * @param ProductRepositoryInterface $productRepository
     * @return Product
     * @throws ProductNotFoundException
     */
    public static function createById(ProductId $productId, ProductRepositoryInterface $productRepository): Product
    {
        $productModel = $productRepository->find($productId->getId());

        if ($productModel === null) {
            throw new ProductNotFoundException();
        }

        return self::createFromModel($productModel);
    }
}