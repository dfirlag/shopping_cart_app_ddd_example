<?php

declare(strict_types=1);

namespace App\Catalog\Application;

use App\Catalog\Application\Dto\PaginatedCatalogDto;
use App\Catalog\Domain\Catalog\Factory\CatalogQueryFactory;
use App\Catalog\Domain\Catalog\ValueObject\CatalogId;
use App\Catalog\Infrastructure\Persistence\Mysql\Repository\CatalogReadModelRepository;

/**
 * Class CatalogQueryService
 *
 * @package App\Catalog\Application
 */
class CatalogQueryService {

    /**
     * @param CatalogReadModelRepository
     */
    private $catalogReadModelRepository;

    /**
     * CatalogReadModelCommandService constructor.
     *
     * @param CatalogReadModelRepository $catalogReadModelRepository
     */
    public function __construct(CatalogReadModelRepository $catalogReadModelRepository) {
        $this->catalogReadModelRepository = $catalogReadModelRepository;
    }

    /**
     * @param CatalogId $catalogId
     * @param int       $page
     * @return PaginatedCatalogDto
     */
    public function getPaginatedCatalog(CatalogId $catalogId, int $page): PaginatedCatalogDto {
        $catalogQuery = CatalogQueryFactory::createPaginatedCatalog(
            $catalogId,
            $page,
            $onPage = 3,
            $this->catalogReadModelRepository
        );

        return new PaginatedCatalogDto($catalogQuery);
    }
}