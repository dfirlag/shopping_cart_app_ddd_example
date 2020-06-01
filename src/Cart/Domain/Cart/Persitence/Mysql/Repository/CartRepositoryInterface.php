<?php

declare(strict_types=1);

namespace App\Cart\Domain\Persitence\Mysql\Repository;

use App\Cart\Domain\Cart\ValueObject\CartUuid;

/**
 * Interface CartRepositoryInterface
 *
 * @package App\Cart\Domain\Persitence\Mysql\Repository
 */
interface CartRepositoryInterface {

    /**
     * @param CartUuid $cartUuid
     * @return mixed
     */
    public function createEmpty(CartUuid $cartUuid): void;
}