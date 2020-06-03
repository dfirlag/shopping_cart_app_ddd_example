<?php

declare(strict_types=1);

namespace App\Catalog\UserInterface\Http;

use App\Catalog\Application\CatalogQueryService;
use App\Catalog\Domain\Catalog\Exception\CatalogNotFoundException;
use App\Catalog\Domain\Catalog\ValueObject\CatalogId;
use App\Shared\UserInterface\Http\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/catalog")
 */
class CatalogQueryController extends AbstractController {

    /**
     * @var CatalogQueryService
     */
    private $catalogQueryService;

    /**
     * CatalogQueryController constructor.
     *
     * @param CatalogQueryService $catalogQueryService
     */
    public function __construct(CatalogQueryService $catalogQueryService) {
        $this->catalogQueryService = $catalogQueryService;
    }


    /**
     * @Route("/getPaginatedCatalog/{catalogId}/{page}", methods={"GET"})
     */
    public function getPaginatedCatalog($catalogId, $page): Response {
        try {
            $paginatedCatalogDto = $this->catalogQueryService->getPaginatedCatalog(
                new CatalogId((int)$catalogId),
                (int)$page
            );
        } catch (CatalogNotFoundException $e) {
            return $this->getErrorJsonResponse("Catalog does not exist");
        }

        $response =  new JsonResponse();
        $response->setContent($paginatedCatalogDto);
        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }
}