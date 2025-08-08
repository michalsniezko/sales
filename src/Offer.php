<?php

declare(strict_types=1);

namespace Sales;

readonly class Offer
{
    private float $totalBeforeDiscount;
    private float $totalAfterDiscount;
    private float $discountAmount;
    private DiscountType $appliedDiscount;

    /** @param array<Product> $products */
    public function __construct(array $products, float $discountAmount, DiscountType $appliedDiscount)
    {
        $this->totalBeforeDiscount = array_sum(array_map(fn(Product $p) => $p->getPrice(), $products));
        $this->discountAmount = $discountAmount;
        $this->totalAfterDiscount = $this->totalBeforeDiscount - $discountAmount;
        $this->appliedDiscount = $appliedDiscount;
    }

    public function getTotalBeforeDiscount(): float
    {
        return $this->totalBeforeDiscount;
    }

    public function getTotalAfterDiscount(): float
    {
        return $this->totalAfterDiscount;
    }

    public function getDiscountAmount(): float
    {
        return $this->discountAmount;
    }

    public function getAppliedDiscount(): DiscountType
    {
        return $this->appliedDiscount;
    }
}
