<?php

namespace App\Traits;

trait FormatsPrices
{
    /**
     * Format a given number as a price with the Euro symbol.
     *
     * @param float $amount
     */
    public function formatPrice(float $amount): string
    {
        return number_format($amount, 2, ',', '.') . ' €';
    }

}