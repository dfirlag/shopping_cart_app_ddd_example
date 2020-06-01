<?php

declare(strict_types=1);

namespace Cart\Application\Dto;

/**
 * Class CartIdDto
 *
 * @package Cart\Application\Dto
 */
class CartIdDto {

    /**
     * @var string
     */
    private $uuid;

    /**
     * CartIdDto constructor.
     *
     * @param string $uuid
     */
    public function __construct(string $uuid) { $this->uuid = $uuid; }

    /**
     * @return string
     */
    public function __toString(): string {
        return json_encode([
            'cart_uuid' => $this->uuid
        ]);
    }
}