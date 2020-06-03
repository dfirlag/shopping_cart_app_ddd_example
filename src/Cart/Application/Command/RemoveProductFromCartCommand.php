<?php

declare(strict_types=1);

namespace App\Cart\Application\Command;

use App\Shared\Application\Command\CommandInterface;

/**
 * Class RemoveProductFromCartCommand
 *
 * @package App\Cart\Application\Command
 */
final class RemoveProductFromCartCommand implements CommandInterface {

    /**
     * @var int
     */
    private $cartId;

    /**
     * @var int
     */
    private $productId;

    /**
     * RemoveProductFromCartCommand constructor.
     *
     * @param string $cartId
     * @param int $productId
     */
    public function __construct(string $cartId, int $productId) {
        $this->cartId = $cartId;
        $this->productId = $productId;
    }

    /**
     * @return string
     */
    public function getCartId(): string {
        return $this->cartId;
    }

    /**
     * @return int
     */
    public function getProductId(): int {
        return $this->productId;
    }
}