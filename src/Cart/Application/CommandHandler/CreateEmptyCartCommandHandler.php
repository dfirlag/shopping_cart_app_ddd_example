<?php

declare(strict_types=1);

namespace App\Cart\Application\CommandHandler;

use App\Cart\Application\CartCommandService;
use App\Cart\Application\Command\CreateEmptyCartCommand;
use App\Cart\Domain\Cart\ValueObject\CartUuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class CreateEmptyCartCommandHandler
 *
 * @package App\Cart\Application\CommandHandler
 */
final class CreateEmptyCartCommandHandler implements MessageHandlerInterface  {

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
     * @param CreateEmptyCartCommand $createEmptyCartCommand
     * @throws \App\Cart\Domain\Cart\Exception\InvalidCartUuidException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(CreateEmptyCartCommand $createEmptyCartCommand) {
        $this->cartCommandService->createEmptyCart(
            new CartUuid($createEmptyCartCommand->getCartId())
        );
    }
}