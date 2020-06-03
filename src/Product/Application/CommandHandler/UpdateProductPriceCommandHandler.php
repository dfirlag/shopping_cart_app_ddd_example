<?php

declare(strict_types=1);

namespace App\Product\Application\CommandHandler;

use App\Product\Application\Command\UpdateProductPriceCommand;
use App\Product\Application\ProductCommandService;
use App\Shared\Domain\ValueObject\ProductId;
use App\Product\Domain\Product\ValueObject\ProductPrice;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class UpdateProductPriceCommandHandler
 *
 * @package App\Product\Application\CommandHandler
 */
final class UpdateProductPriceCommandHandler implements MessageHandlerInterface {

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
     * @param UpdateProductPriceCommand $updateProductPriceCommand
     * @throws \App\Product\Domain\Product\Exception\InvalidProductPriceException
     * @throws \App\Product\Domain\Product\Exception\ProductNotFoundException
     */
    public function __invoke(UpdateProductPriceCommand $updateProductPriceCommand) {
        $this->productCommandService->updateProductPrice(
            new ProductId($updateProductPriceCommand->getProductId()),
            new ProductPrice($updateProductPriceCommand->getPrice())
        );
    }
}