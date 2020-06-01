<?php

namespace App\Product\Application;

use App\Product\Domain\Product\Exception\InvalidProductPriceException;
use App\Product\Domain\Product\Exception\ProductNotFoundException;
use App\Product\Domain\Product\Factory\ProductFactory;
use App\Product\Domain\Product\ValueObject\ProductId;
use App\Product\Domain\Product\ValueObject\ProductName;
use App\Product\Domain\Product\ValueObject\ProductPrice;
use App\Product\Infrastructure\Persistence\Mysql\Repository\ProductRepository;
use App\Shared\Application\MoneyHelperService;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Money\Currencies\ISOCurrencies;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

class ProductCommandService {

    /**
     * @var ProductRepository|ObjectRepository|EntityRepository
     */
    private $productRepository;

    /**
     * ProductCommandService constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository) {
        $this->productRepository = $productRepository;
    }

    /**
     * @param ProductId   $productId
     * @param ProductName $productName
     * @throws ProductNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateProductName(ProductId $productId, ProductName $productName): void {
        $product = ProductFactory::createById($productId, $this->productRepository);
        $product->updateProductName($productName);

        $this->productRepository->saveProduct($product);
    }

    /**
     * @param ProductId    $productId
     * @param ProductPrice $productPrice
     * @throws InvalidProductPriceException
     * @throws ProductNotFoundException
     */
    public function updateProductPrice(ProductId $productId, ProductPrice $productPrice): void {
        $product = ProductFactory::createById($productId, $this->productRepository);

        if ($productPrice->getPrice()->isNegative()) {
            throw new InvalidProductPriceException("Product price cannot be negative");
        }

        $product->updateProductPrice($productPrice);

        $this->productRepository->saveProduct($product);
    }

}