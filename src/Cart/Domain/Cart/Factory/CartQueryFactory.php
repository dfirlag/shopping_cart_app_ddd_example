<?php

declare(strict_types=1);

namespace App\Cart\Domain\Cart\Factory;

use App\Cart\Domain\Cart\Builder\CartQueryBuilder;
use App\Cart\Domain\Cart\CartQuery;
use App\Cart\Domain\Cart\Persitence\Mysql\CartReadModelInterface;
use App\Cart\Domain\Cart\Persitence\Mysql\Repository\CartReadModelRepositoryInterface;
use App\Cart\Domain\Cart\ValueObject\CartUuid;
use Money\Currency;
use Money\Money;

/**
 * Class CartQueryFactory
 *
 * @package App\Cart\Domain\Cart\Factory
 */
class CartQueryFactory {

    /**
     * @param CartUuid $cartUuid
     * @param array    $cartModels
     * @return CartQuery
     */
    public static function createFromModel(CartUuid $cartUuid, array $cartModels): CartQuery
    {
        $builder = CartQueryBuilder::create()
            ->setCartUuid($cartUuid);

        foreach ($cartModels as $cartModel) {
            /** @var CartReadModelInterface $cartModel */
            $builder->addProduct(
                $cartModel->getProductId(),
                $cartModel->getProductName(),
                new Money($cartModel->getProductPrice(), new Currency($cartModel->getCurrency()))
            );
        }

        return $builder->build();
    }

    /**
     * @param CartUuid                         $cartUuid
     * @param CartReadModelRepositoryInterface $cartReadModelRepository
     * @return CartQuery
     */
    public static function createById(CartUuid $cartUuid, CartReadModelRepositoryInterface $cartReadModelRepository): CartQuery
    {
        $cartModels = $cartReadModelRepository->findBy(['cartId' => $cartUuid->getUuid()]);
        return self::createFromModel($cartUuid, $cartModels);
    }
}