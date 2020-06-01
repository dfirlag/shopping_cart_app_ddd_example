<?php

declare(strict_types=1);

namespace App\Product\Domain\Product\ValueObject;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

class ProductPrice {

    /**
     * @var Money
     */
    private $price;

    /**
     * ProductPrice constructor.
     *
     * @param Money $price
     */
    public function __construct(Money $price) {
        $this->price = $price;
    }

    public static function createFromFloatString($price) {
        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);

        return $moneyParser->parse((string)$price);
    }

    /**
     * @return Money
     */
    public function getPrice(): Money {
        return $this->price;
    }
}