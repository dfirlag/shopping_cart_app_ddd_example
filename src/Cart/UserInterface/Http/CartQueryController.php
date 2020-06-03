<?php

declare(strict_types=1);

namespace App\Cart\UserInterface\Http;

use App\Cart\Application\CartQueryService;
use App\Cart\Domain\Cart\Exception\CartNotFoundException;
use App\Cart\Domain\Cart\ValueObject\CartUuid;
use App\Shared\UserInterface\Http\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartQueryController extends AbstractController {

    /**
     * @var CartQueryService
     */
    private $cartQueryService;

    /**
     * CartQueryController constructor.
     *
     * @param CartQueryService $cartQueryService
     */
    public function __construct(CartQueryService $cartQueryService) {
        $this->cartQueryService = $cartQueryService;
    }

    /**
     * @Route("/get/{cartId}", methods={"GET"})
     */
    public function showCart($cartId): Response {
        try {
            $cartDto = $this->cartQueryService->getCartDto(new CartUuid($cartId));
        } catch (CartNotFoundException $e) {
            return $this->getErrorJsonResponse("Cart does not exist");
        }

        $response =  new JsonResponse();
        $response->setContent($cartDto);
        $response->setStatusCode(Response::HTTP_OK);
        return $response;
    }
}