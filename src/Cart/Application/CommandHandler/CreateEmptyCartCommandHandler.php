<?php

namespace App\Cart\Application\CommandHandler;

use App\Cart\Application\CartCommandService;
use App\Cart\Application\Command\CreateEmptyCartCommand;
use App\Cart\Domain\Cart\ValueObject\CartUuid;

class CreateEmptyCartCommandHandler {

    /**
     * @var CartCommandService
     */
    private $cartCommandService;

    /**
     * CreateEmptyCartCommandHandler constructor.
     *
     * @param CartCommandService $cartCommandService
     */
    public function __construct(CartCommandService $cartCommandService) {
        $this->cartCommandService = $cartCommandService;
    }

    public function __invoke(CreateEmptyCartCommand $createEmptyCartCommand) {
        $this->cartCommandService->createEmptyCart(
            new CartUuid($createEmptyCartCommand->getCartId())
        );
    }
}