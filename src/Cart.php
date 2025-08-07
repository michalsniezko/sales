<?php

declare(strict_types=1);

namespace Sales;

use Sales\Discount\DiscountInterface;

class Cart
{
    private array $products = [];

    public function add(Product $product): void
    {
        $this->products[] = $product;
    }

    /** @param array<DiscountInterface> $discounts */
    public function checkout(array $discounts): Offer
    {
        $bestOffer = new Offer($this->products, 0, DiscountType::NO_DISCOUNT);

        foreach ($discounts as $discount) {
            $offer = $discount->apply($this->products);
            if ($offer->getDiscountAmount() > $bestOffer->getDiscountAmount()) {
                $bestOffer = $offer;
            }
        }

        return $bestOffer;
    }
}
