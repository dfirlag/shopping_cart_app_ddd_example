<?php

declare(strict_types=1);

namespace App\Cart\UserInterface\Http;

use App\Cart\Application\CartCommandService;
use App\Cart\Application\Command\CreateEmptyCartCommand;
use App\Shared\UserInterface\Http\AbstractController;
use Cart\Application\Dto\CartIdDto;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    public function addProductToCart(): void
    {

    }

    public function removeProductFromCart(): void
    {

    }


}