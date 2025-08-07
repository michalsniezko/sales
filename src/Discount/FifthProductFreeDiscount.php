<?php

declare(strict_types=1);

namespace Sales\Discount;

use Sales\DiscountType;
use Sales\Offer;
use Sales\Product;

class FifthProductFreeDiscount implements DiscountInterface
{
    /** @param array<Product> $products */
    public function apply(array $products): Offer
    {
        $grouped = [];
        foreach ($products as $product) {
            $grouped[$product->getName()][] = $product;
        }

        $discount = 0;

        foreach ($grouped as $group) {
            /** @var Product $product */
            foreach ($group as $index => $product) {
                if (($index + 1) % 5 === 0) {
                    $discount += $product->getPrice();
                }
            }
        }

        return new Offer($products, $discount, DiscountType::FIFTH_PRODUCT_FREE);
    }
}
