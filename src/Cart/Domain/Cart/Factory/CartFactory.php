<?php

declare(strict_types=1);

namespace App\Cart\Domain\Cart\Factory;

use App\Cart\Domain\Cart\Cart;
use App\Cart\Domain\Cart\Exception\CartNotFoundException;
use App\Cart\Domain\Cart\Persitence\Mysql\CartModelInterface;
use App\Cart\Domain\Cart\ValueObject\CartProductCollection;
use App\Cart\Domain\Cart\ValueObject\CartUuid;
use App\Cart\Domain\Cart\Persitence\Mysql\Repository\CartRepositoryInterface;

/**
 * Class CartFactory
 *
 * @package App\Cart\Domain\Cart\Factory
 */
class CartFactory {

    /**
     * @param CartModelInterface $cartModel
     * @return Cart
     */
    public static function createFromModel(CartModelInterface $cartModel): Cart
    {
        return new Cart(
            new CartUuid($cartModel->getId()),
            CartProductCollection::createFromArray($cartModel->getProductIds()),
            $cartModel->getTotalPrice()
        );
    }

    /**
     * @param CartUuid                $cartUuid
     * @param CartRepositoryInterface $cartRepository
     * @return Cart
     * @throws CartNotFoundException
     */
    public static function createById(CartUuid $cartUuid, CartRepositoryInterface $cartRepository): Cart
    {
        $cartModel = $cartRepository->find($cartUuid->getUuid());

        if ($cartModel === null) {
            throw new CartNotFoundException();
        }

        return self::createFromModel($cartModel);
    }
}