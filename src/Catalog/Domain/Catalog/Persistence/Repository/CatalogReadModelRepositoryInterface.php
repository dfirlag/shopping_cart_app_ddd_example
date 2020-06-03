<?php

declare(strict_types=1);

namespace App\Catalog\Domain\Catalog\Persistence\Repository;

use App\Catalog\Domain\Catalog\ValueObject\CatalogId;

/**
 * Interface CatalogReadModelRepositoryInterface
 *
 * @package App\Catalog\Domain\Catalog\Persistence\Repository
 */
interface CatalogReadModelRepositoryInterface {

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param CatalogId $catalogId
     * @param int       $page
     * @param int       $itemPerPage
     * @return mixed
     */
    public function getPaginated(CatalogId $catalogId, int $page, int $itemPerPage);
}