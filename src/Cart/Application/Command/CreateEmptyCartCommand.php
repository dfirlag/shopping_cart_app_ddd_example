<?php

declare(strict_types=1);

namespace App\Cart\Application\Command;

use App\Shared\Application\Command\CommandInterface;

/**
 * Class CreateEmptyCartCommand
 *
 * @package App\Cart\Application\Command
 */
final class CreateEmptyCartCommand implements CommandInterface {

    /**
     * @var string
     */
    private $cartId;

    /**
     * CreateEmptyCartCommand constructor.
     *
     * @param string $cartId
     */
    public function __construct(string $cartId) { $this->cartId = $cartId; }

    /**
     * @return string
     */
    public function getCartId(): string {
        return $this->cartId;
    }
}