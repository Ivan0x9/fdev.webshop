<?php

namespace App\Traits;

use App\Models\Order;

trait OrderModificators
{
    protected float $taxRate = 0.23;
    protected float $shippingLimit = 100.0;
    protected float $shippingDiscount = 0.10;

    /**
     * Calculate and update payment details for the order.
     *
     * @param Order $order
     * @return void
     */
    public function updatePaymentDetails(): void
    {
        $amount = $this->calculateAmount($this);

        $tax = $this->calculateTax($amount);

        $shipping = $this->isAboveShippingLimit($amount);

        $paymentDetails = [
            'amount' => $amount,
            'tax' => $tax,
        ];

        $total = $amount + $tax;

        if ($shipping) {
            $shippingDiscount = $this->calculateshippingDiscount($amount);

            $paymentDetails['discount'] = $shippingDiscount;

            $total -= $shippingDiscount;
        }

        $this->payment_details = json_encode($paymentDetails);

        $this->total = $total;

        $this->save();
    }

    /**
     * Calculate the total amount of the order.
     *
     * @return float
     */
    protected function calculateAmount(): float
    {
        return (float) $this->items->sum(function ($item) {
            return round($item->price * $item->quantity, 2);
        });
    }

    /**
     * Calculate the tax for a given amount.
     *
     * @param float $amount
     * @return float
     */
    protected function calculateShippingDiscount(float $amount): float
    {
        return (float) round($amount * $this->shippingDiscount, 2);
    }

    /**
     * Calculate the tax for a given amount.
     *
     * @param float $amount
     * @return float
     */
    protected function calculateTax(float $amount): float
    {
        return (float) round($amount * $this->taxRate, 2);
    }

    /**
     * Calculate the shipping cost based on the total amount.
     *
     * @param float $amount
     * @return float
     */
    protected function isAboveShippingLimit(float $amount): float
    {
        return $amount > $this->shippingLimit ?? false;
    }
}