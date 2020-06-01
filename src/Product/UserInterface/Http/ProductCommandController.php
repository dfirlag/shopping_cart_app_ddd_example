<?php

declare(strict_types=1);

namespace App\Product\UserInterface\Http;

use App\Product\Application\Command\UpdateProductNameCommand;
use App\Product\Application\Command\UpdateProductPriceCommand;
use App\Product\Domain\Product\Exception\ProductNotFoundException;
use App\Shared\UserInterface\Http\AbstractController;
use Money\Money;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductCommandController extends AbstractController {

    /**
     * @var MessageBusInterface
     */
    private $bus;

    /**
     * ProductCommandController constructor.
     *
     * @param MessageBusInterface $bus
     */
    public function __construct(MessageBusInterface $bus) {
        $this->bus = $bus;
    }

    /**
     * @Route("/updateName/{productId}", methods={"POST"})
     */
    public function updateProductName($productId, Request $request): Response {
        $productName = filter_var($request->get('productName', ''), FILTER_SANITIZE_STRING);

        if (empty($productName)) {
            return $this->getErrorJsonResponse("Invalid product name");
        }

        $command = new UpdateProductNameCommand((int)$productId, (string)$productName);

        try {
            $this->bus->dispatch($command);
        } catch (ProductNotFoundException $e) {
            return $this->getErrorJsonResponse("Product not found");
        }

        return $this->getOkJsonResponse();
    }

    /**
     * @Route("/updatePrice/{productId}", methods={"POST"})
     */
    public function updateProductPrice($productId, Request $request): Response {
        $productPrice = $request->request->get('productPrice', '');

        if (empty($productPrice)) {
            return $this->getErrorJsonResponse("Invalid product price");
        }

        $command = new UpdateProductPriceCommand((int)$productId, Money::PLN($productPrice));

        try {
            $this->bus->dispatch($command);
        } catch (ProductNotFoundException $e) {
            return $this->getErrorJsonResponse("Product not found");
        }

        return $this->getOkJsonResponse();
    }
}