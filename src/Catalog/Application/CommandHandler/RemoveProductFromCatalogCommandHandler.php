<?php

declare(strict_types=1);

namespace App\Catalog\Application\CommandHandler;

use App\Catalog\Application\CatalogCommandService;
use App\Catalog\Application\Command\RemoveProductFromCatalogCommand;
use App\Catalog\Domain\Catalog\ValueObject\CatalogId;
use App\Catalog\Domain\Catalog\ValueObject\ProductId;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RemoveProductFromCatalogCommandHandler implements MessageHandlerInterface {

    /**
     * @var CatalogCommandService
     */
    private $catalogCommandService;

    /**
     * RemoveProductFromCatalogCommandHandler constructor.
     *
     * @param CatalogCommandService $catalogCommandService
     */
    public function __construct(CatalogCommandService $catalogCommandService) {
        $this->catalogCommandService = $catalogCommandService;
    }

    /**
     * @param RemoveProductFromCatalogCommand $removeProductFromCatalogCommand
     * @throws \App\Catalog\Domain\Catalog\Exception\CatalogNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(RemoveProductFromCatalogCommand $removeProductFromCatalogCommand) {
        $this->catalogCommandService->removeProductFromCatalog(
            new CatalogId($removeProductFromCatalogCommand->getCatalogId()),
            new ProductId($removeProductFromCatalogCommand->getProductId())
        );
    }
}