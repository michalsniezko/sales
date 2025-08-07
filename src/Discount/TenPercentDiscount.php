<?php

declare(strict_types=1);

namespace Sales\Discount;

use Sales\DiscountType;
use Sales\Offer;
use Sales\Product;

class TenPercentDiscount implements DiscountInterface
{
    /** @param array<Product> $products */
    public function apply(array $products): Offer
    {
        $total = array_sum(array_map(fn($p) => $p->getPrice(), $products));

        if ($total > 100) {
            $discount = $total * 0.10;
            return new Offer($products, $discount, DiscountType::TEN_PERCENT_OFF_OVER_100);
        }

        return new Offer($products, 0, DiscountType::NO_DISCOUNT);
    }
}
