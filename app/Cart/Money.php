<?php

namespace App\Cart;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money as BaseMoney;
use NumberFormatter;

class Money
{
    protected $money;

    /**
     * Money constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->money = new BaseMoney($value, new Currency('GBP'));
    }

    /**
     * Return formatted price.
     *
     * @return string
     */
    public function formatted()
    {
        $formatter = new IntlMoneyFormatter(
            new NumberFormatter('en_GB', NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        return $formatter->format($this->money);
    }

    /**
     * Return the numeric value of the price.
     *
     * @return string
     */
    public function amount()
    {
        return $this->money->getAmount();
    }
}