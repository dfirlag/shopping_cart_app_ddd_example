<?php

declare(strict_types=1);

namespace App\Catalog\UserInterface\Http;

use App\Catalog\Application\Command\AddProductToCatalogCommand;
use App\Catalog\Application\Command\RemoveProductFromCatalogCommand;
use App\Product\Domain\Product\Exception\ProductNotFoundException;
use App\Shared\UserInterface\Http\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/catalog")
 */
class CatalogCommandController extends AbstractController {

    /**
     * @var MessageBusInterface
     */
    private $bus;

    /**
     * ProductCommandController constructor.
     *
     * @param MessageBusInterface $bus
     */
    public function __construct(MessageBusInterface $bus) {
        $this->bus = $bus;
    }

    /**
     * @Route("/addProduct/{catalogId}", methods={"POST"})
     */
    public function addProductToCatalog($catalogId, Request $request): Response
    {
        $productId = (int)$request->get('productId', 0);

        if (empty($productId)) {
            return $this->getErrorJsonResponse("Product id is missing");
        }

        $command = new AddProductToCatalogCommand((int)$catalogId, $productId);

        try {
            $this->bus->dispatch($command);
        } catch (ProductNotFoundException $e) {
            return $this->getErrorJsonResponse("Product not found");
        }

        return $this->getOkJsonResponse();
    }

    /**
     * @Route("/removeProduct/{catalogId}", methods={"POST"})
     */
    public function removeProductFromCatalog($catalogId, Request $request): Response
    {
        $productId = (int)$request->get('productId', 0);

        if (empty($productId)) {
            return $this->getErrorJsonResponse("Product id is missing");
        }

        $command = new RemoveProductFromCatalogCommand((int)$catalogId, $productId);

        try {
            $this->bus->dispatch($command);
        } catch (ProductNotFoundException $e) {
            return $this->getErrorJsonResponse("Product not found");
        }

        return $this->getOkJsonResponse();
    }
}