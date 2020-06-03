<?php

declare(strict_types=1);

namespace App\Product\Application;

use App\Product\Domain\Product\Factory\ProductFactory;
use App\Product\Domain\Product\Product;
use App\Product\Infrastructure\Persistence\Mysql\Repository\ProductRepository;
use App\Shared\Domain\ValueObject\ProductId;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Money\Money;

/**
 * Class ProductQueryService
 *
 * @package App\Product\Application
 */
class ProductQueryService {

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
     * @param array $products
     * @return Money
     */
    public function getTotalAmountFromProducts(array $products): Money {
        $total = Money::PLN(0);

        foreach ($products as $productModel) {
            $product = ProductFactory::createFromModel($productModel);

            $total = $total->add($product->getProductPrice()->getPrice());
        }

        return $total;
    }

    /**
     * @param ProductId $productId
     * @return \App\Product\Domain\Product\Product
     * @throws \App\Product\Domain\Product\Exception\ProductNotFoundException
     */
    public function getProduct(ProductId $productId): Product {
        return ProductFactory::createById($productId, $this->productRepository);
    }
}