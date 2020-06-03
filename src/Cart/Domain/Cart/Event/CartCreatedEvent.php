<?php

declare(strict_types=1);

namespace App\Cart\Domain\Cart\Event;

/**
 * Class CartHasnBeenCreatedEvent
 *
 * @package App\Cart\Domain\Cart\Event
 */
class CartCreatedEvent {

    public const NAME = "cart.created";

    /**
     * @var string
     */
    private $cartUuid;

    /**
     * CartHasnBeenCreatedEvent constructor.
     *
     * @param string $cartUuid
     */
    public function __construct(string $cartUuid) { $this->cartUuid = $cartUuid; }

    /**
     * @return string
     */
    public function getCartUuid(): string {
        return $this->cartUuid;
    }
}