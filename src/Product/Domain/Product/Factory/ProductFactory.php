<?php

declare(strict_types=1);

namespace App\Product\Domain\Product\Factory;

use App\Product\Domain\Product\Exception\ProductNotFoundException;
use App\Product\Domain\Product\Persistence\ProductModel;
use App\Product\Domain\Product\Persistence\Repository\ProductRepositoryInterface;
use App\Product\Domain\Product\Product;
use App\Shared\Domain\ValueObject\ProductId;
use App\Product\Domain\Product\ValueObject\ProductName;
use App\Product\Domain\Product\ValueObject\ProductPrice;
use Money\Currency;
use Money\Money;

/**
 * Class ProductFactory
 *
 * @package App\Product\Domain\Product\Factory
 */
class ProductFactory {

    /**
     * @param ProductModel $productModel
     * @return Product
     */
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