<?php

declare(strict_types=1);

namespace App\Cart\Application\CommandHandler;

use App\Cart\Application\CartCommandService;
use App\Cart\Application\Command\AddProductToCartCommand;
use App\Cart\Domain\Cart\ValueObject\CartUuid;
use App\Shared\Domain\ValueObject\ProductId;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class AddProductToCartCommandHandler
 *
 * @package App\Cart\Application\CommandHandler
 */
final class AddProductToCartCommandHandler implements MessageHandlerInterface {

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

    /**
     * @param AddProductToCartCommand $addProductToCartCommand
     * @throws \App\Cart\Domain\Cart\Exception\CartNotFoundException
     */
    public function __invoke(AddProductToCartCommand $addProductToCartCommand) {
        $this->cartCommandService->addProductToCart(
            new CartUuid($addProductToCartCommand->getCartId()),
            new ProductId($addProductToCartCommand->getProductId())
        );
    }
}