<?php

declare(strict_types=1);

namespace App\Cart\Domain\Cart\Persitence\Mysql\Repository;

use App\Cart\Domain\Cart\ValueObject\CartUuid;

/**
 * Interface CartRepositoryInterface
 *
 * @package App\Cart\Domain\Persitence\Mysql\Repository
 */
interface CartRepositoryInterface {

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param CartUuid $cartUuid
     * @return mixed
     */
    public function createEmpty(CartUuid $cartUuid): void;
}