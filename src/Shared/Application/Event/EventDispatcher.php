<?php

declare(strict_types=1);

namespace App\Shared\Application\Event;

use App\Cart\Application\EventSubscriber\CartEventSubscriber;
use App\Catalog\Application\EventSubscriber\CatalogEventSubscriber;

/**
 * Class EventDispatcher
 *
 * @package App\Shared\Application\Event
 */
class EventDispatcher extends \Symfony\Component\EventDispatcher\EventDispatcher {

    /**
     * @var CartEventSubscriber
     */
    private $cartEventSubscriber;

    /**
     * @var CatalogEventSubscriber
     */
    private $catalogEventSubscriber;

    /**
     * EventDispatcher constructor.
     *
     * @param CartEventSubscriber $cartEventSubscriber
     * @param CatalogEventSubscriber $catalogEventSubscriber
     */
    public function __construct(
        CartEventSubscriber $cartEventSubscriber,
        CatalogEventSubscriber $catalogEventSubscriber
    ) {
        $this->addSubscriber($cartEventSubscriber);
        $this->addSubscriber($catalogEventSubscriber);
    }
}