<?php

declare(strict_types=1);

namespace App\Cart\Application\CommandHandler;

use App\Cart\Application\CartCommandService;
use App\Cart\Application\Command\RemoveProductFromCartCommand;
use App\Cart\Domain\Cart\ValueObject\CartUuid;
use App\Shared\Domain\ValueObject\ProductId;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class RemoveProductFromCartCommandHandler
 *
 * @package App\Cart\Application\CommandHandler
 */
final class RemoveProductFromCartCommandHandler implements MessageHandlerInterface {

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
     * @param RemoveProductFromCartCommand $removeProductFromCartCommand
     * @throws \App\Cart\Domain\Cart\Exception\CartNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(RemoveProductFromCartCommand $removeProductFromCartCommand) {
        $this->cartCommandService->removeProductFromCart(
            new CartUuid($removeProductFromCartCommand->getCartId()),
            new ProductId($removeProductFromCartCommand->getProductId())
        );
    }
}