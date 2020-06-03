<?php

declare(strict_types=1);

namespace App\Cart\Domain\Cart\Persitence\Mysql\Repository;

/**
 * Interface CartReadModelRepositoryInterface
 *
 * @package App\Cart\Domain\Cart\Persitence\Mysql\Repository
 */
interface CartReadModelRepositoryInterface {

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);
}