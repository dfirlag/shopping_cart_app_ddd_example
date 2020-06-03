<?php

declare(strict_types=1);

namespace App\Cart\UserInterface\Http;

use App\Cart\Application\CartCommandService;
use App\Cart\Application\Command\AddProductToCartCommand;
use App\Cart\Application\Command\CreateEmptyCartCommand;
use App\Cart\Application\Command\RemoveProductFromCartCommand;
use App\Catalog\Domain\Catalog\Exception\CatalogNotFoundException;
use App\Shared\UserInterface\Http\AbstractController;
use App\Cart\Application\Dto\CartIdDto;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartCommandController extends AbstractController {

    /**
     * @var MessageBusInterface
     */
    private $bus;

    /**
     * @var CartCommandService
     */
    private $cartCommandService;

    /**
     * ProductCommandController constructor.
     *
     * @param MessageBusInterface $bus
     * @param CartCommandService $cartCommandService
     */
    public function __construct(MessageBusInterface $bus, CartCommandService $cartCommandService) {
        $this->bus = $bus;
        $this->cartCommandService = $cartCommandService;
    }

    /**
     * @Route("/createEmpty", methods={"PUT"})
     */
    public function createEmptyCart(): Response
    {
        $cartUuid = $this->cartCommandService->createNewCartUuid();
        $command = new CreateEmptyCartCommand($cartUuid);

        try {
            $this->bus->dispatch($command);
        } catch (\Exception $e) {
            return $this->getErrorJsonResponse("Something went wrong");
        }

        $response =  new JsonResponse();
        $response->setContent(new CartIdDto($cartUuid));
        $response->setStatusCode(Response::HTTP_CREATED);
        return $response;
    }

    /**
     * @Route("/addProduct/{cartId}", methods={"POST"})
     */
    public function addProductToCart($cartId, Request $request): Response
    {
        $productId = (int)$request->get('productId', 0);

        if (empty($productId)) {
            return $this->getErrorJsonResponse("Product id is missing");
        }

        $command = new AddProductToCartCommand($cartId, $productId);

        try {
            $this->bus->dispatch($command);
        } catch (CatalogNotFoundException $e) {
            return $this->getErrorJsonResponse("Catalog not found");
        }

        return $this->getOkJsonResponse();
    }

    /**
     * @Route("/removeProduct/{cartId}", methods={"POST"})
     */
    public function removeProductFromCart($cartId, Request $request): Response
    {
        $productId = (int)$request->get('productId', 0);

        if (empty($productId)) {
            return $this->getErrorJsonResponse("Product id is missing");
        }

        $command = new RemoveProductFromCartCommand((string)$cartId, $productId);

        try {
            $this->bus->dispatch($command);
        } catch (CatalogNotFoundException $e) {
            return $this->getErrorJsonResponse("Catalog not found");
        }

        return $this->getOkJsonResponse();
    }
}