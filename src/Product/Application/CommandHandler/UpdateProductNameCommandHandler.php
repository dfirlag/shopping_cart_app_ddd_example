<?php

declare(strict_types=1);

namespace App\Product\Application\CommandHandler;

use App\Product\Application\Command\UpdateProductNameCommand;
use App\Product\Application\ProductCommandService;
use App\Shared\Domain\ValueObject\ProductId;
use App\Product\Domain\Product\ValueObject\ProductName;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class UpdateProductNameCommandHandler
 *
 * @package App\Product\Application\CommandHandler
 */
final class UpdateProductNameCommandHandler implements MessageHandlerInterface {

    /**
     * @var ProductCommandService
     */
    private $productCommandService;

    /**
     * UpdateProductNameCommandHandler constructor.
     *
     * @param ProductCommandService $productCommandService
     */
    public function __construct(ProductCommandService $productCommandService) {
        $this->productCommandService = $productCommandService;
    }

    /**
     * @param UpdateProductNameCommand $updateProductNameCommand
     * @throws \App\Product\Domain\Product\Exception\ProductNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(UpdateProductNameCommand $updateProductNameCommand) {
        $this->productCommandService->updateProductName(
            new ProductId($updateProductNameCommand->getProductId()),
            new ProductName($updateProductNameCommand->getProductName())
        );
    }
}