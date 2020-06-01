<?php

namespace App\Cart\Application\Command;

class CreateEmptyCartCommand {

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