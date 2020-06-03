<?php

declare(strict_types=1);

namespace App\Cart\Application;

use App\Cart\Application\Dto\CartDto;
use App\Cart\Domain\Cart\CartQuery;
use App\Cart\Domain\Cart\Factory\CartQueryFactory;
use App\Cart\Domain\Cart\ValueObject\CartUuid;
use App\Cart\Infrastructure\Persistence\Mysql\Repository\CartReadModelRepository;
use App\Cart\Infrastructure\Persistence\Mysql\Repository\CartRepository;

/**
 * Class CartQueryService
 *
 * @package App\Cart\Application
 */
class CartQueryService {

    /**
     * @var CartRepository
     */
    private $cartRepository;

    /**
     * @var CartReadModelRepository
     */
    private $cartReadModelRepository;

    /**
     * CartCommandService constructor.
     *
     * @param CartRepository $cartRepository
     * @param CartReadModelRepository $cartReadModelRepository
     */
    public function __construct(CartRepository $cartRepository, CartReadModelRepository $cartReadModelRepository) {
        $this->cartRepository = $cartRepository;
        $this->cartReadModelRepository = $cartReadModelRepository;
    }

    /**
     * @param CartUuid $cartUuid
     * @return CartQuery
     */
    public function getCartQuery(CartUuid $cartUuid): CartQuery {
        return CartQueryFactory::createById($cartUuid, $this->cartReadModelRepository);
    }

    /**
     * @param CartUuid $cartUuid
     * @return CartDto
     */
    public function getCartDto(CartUuid $cartUuid): CartDto {
        return new CartDto(
            $this->getCartQuery($cartUuid)
        );
    }
}